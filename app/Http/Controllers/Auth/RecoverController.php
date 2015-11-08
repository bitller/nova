<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AjaxResponse;
use App\Helpers\Generator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckRecoverCodeRequest;
use App\Http\Requests\Auth\RecoverPasswordRequest;
use App\Http\Requests\Auth\SetNewPasswordRequest;
use App\RecoverCode;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Allow user to recover their password.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RecoverController extends Controller {

    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Render recover page.
     *
     * @return string
     */
    public function index() {
        return view('auth.recover');
    }

    /**
     * Send recover email.
     *
     * @param RecoverPasswordRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function recover(RecoverPasswordRequest $request) {

        $response = new AjaxResponse();

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // Email not found
            $response->setFailMessage(trans('recover.email_not_found'));
            return response($response->get(), $response->badRequest());
        }

        $user->link = url('/recover/'.urlencode($user->id).'/'.Generator::recoverCode($user->id));

        // Send recover email
        Mail::send('emails.reset-password', ['user' => $user], function($m) use($user) {
            $m->from('us@nova-app.com', 'Nova');
            $m->to($user->email, $user->first_name)->subject('Reset password');
        });

        // todo delete recover code after 0.5 hours

        $response->setSuccessMessage(trans('recover.email_sent'));
        return response($response->get());

    }

    /**
     * Check if recover code is valid and determine what should be displayed.
     *
     * @param int $userId
     * @param string $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @internal param string $email
     */
    public function check($userId, $code) {

        $data = [
            'id' => $userId,
            'code' => $code,
        ];

        $recover = RecoverCode::where('user_id', $userId)->where('code', $code)->valid()->first();
        if (!$recover) {
            return abort(404);
        }

        return view('auth.recover-check')->with($data);
    }

    /**
     * @param int $userId
     * @param string $code
     * @param SetNewPasswordRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function setNewPassword($userId, $code, SetNewPasswordRequest $request) {

        $response = new AjaxResponse();

        $recover = RecoverCode::where('user_id', $userId)->where('code', $code)->valid()->first();
        if (!$recover) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->badRequest());
        }

        $user = User::find($userId);
        if (!$user) {
            // User not found
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->badRequest());
        }

        User::where('id', $userId)->update([
            'password' => bcrypt($request->get('new_password'))
        ]);

        $response->setSuccessMessage(trans('recover.password_updated'));
        return response($response->get());
    }

}