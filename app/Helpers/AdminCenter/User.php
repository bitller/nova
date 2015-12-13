<?php

namespace App\Helpers\AdminCenter;

use App\Helpers\AjaxResponse;
use Illuminate\Support\Facades\Auth;

class User {

    public static function changeAccountStatus($status = 1, $userId = false) {

        $response = new AjaxResponse();
        $message = trans('users_manager.account_enabled');

        if ($status == 0) {
            $message = trans('users_manager.account_disabled');
        }

        if (!$userId) {
            $userId = Auth::user()->id;
        }

        \App\User::where('id', $userId)->update(['active' => $status]);
        $response->setSuccessMessage($message);
        $response->addExtraFields(['active' => $status]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

}