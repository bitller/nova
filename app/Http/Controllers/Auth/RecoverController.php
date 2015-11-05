<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RecoverPasswordRequest;
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

    public function recover(RecoverPasswordRequest $request) {

        $user = User::where('email', $request->email)->first();

        // todo generate reset code
        Mail::send('emails.reset-password', ['user' => $user], function($m) use($user) {
            $m->to($user->email, $user->first_name)->subject('Reset password');
        });
        // todo send email with reset link

    }

    public function check() {
        //
    }

}