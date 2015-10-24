<?php

use App\User;
use Illuminate\Support\Facades\Auth;

class Settings {

    /**
     * Handle user email edit.
     *
     * @param string $email
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editUserEmail($email) {

        $response = new \App\Helpers\AjaxResponse();

        // Check if email is already taken
        if (User::where('email', $email)->count()) {
            $response->setFailMessage(trans('settings.email_already_used'));
            return response($response->get(), $response->getDefaultErrorResponseCode());
        }

        User::where('id', Auth::user()->id)->update(['email' => $email]);

        $response->setSuccessMessage('updated');
        return response($response->get());
    }

}