<?php

namespace App\Helpers\AdminCenter;

use App\Bill;
use App\Client;
use App\Helpers\AjaxResponse;
use App\Product;
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

    /**
     * Get clients of given user.
     *
     * @param bool $userId
     * @return mixed
     */
    public static function getClients($userId = false) {

        // If an user id is not given use the id of current logged in user
        if (!$userId) {
            $userId = Auth::user()->id;
        }

        $clients = Client::where('user_id', $userId)->paginate();

        foreach ($clients as &$client) {
            $client->orders = Bill::where('client_id', $client->id)->count();
        }

        return response($clients)->header('Content-Type', 'application/json');
    }

    /**
     * Get custom products of give user.
     *
     * @param bool $userId
     * @return mixed
     */
    public static function getCustomProducts($userId = false) {

        // If user id is not given use the id of current logged in user
        if (!$userId) {
            $userId = Auth::user()->id;
        }

        $customProducts = Product::where('user_id', $userId)->paginate();

        return response($customProducts)->header('Content-Type', 'application/json');
    }

}