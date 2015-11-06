<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AjaxResponse;
use App\Helpers\Generator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RecoverPasswordRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Allow user to recover their password.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RecoverController extends Controller {

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

        $user->link = url('/recover/'.Generator::recoverCode($user->id));

        // Send recover email
        Mail::send('emails.reset-password', ['user' => $user], function($m) use($user) {
            $m->from('us@nova-app.com', 'Nova');
            $m->to($user->email, $user->first_name)->subject('Reset password');
        });

        // todo delete recover code after 3 hours

        $response->setSuccessMessage(trans('recover.email_sent'));
        return response($response->get());

    }

    public function check() {
        //
    }

}