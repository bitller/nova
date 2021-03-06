<?php

namespace App\Helpers;

use App\Language;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Methods to make easier working with user settings
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
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

    /**
     * Return number of displayed bills from user settings.
     *
     * @return mixed
     */
    public static function displayedBills() {
        $settings = Auth::user()->settings()->first();

        // If settings does not exists return a default number
        if (!$settings) {
            return 10;
        }

        return $settings->displayed_bills;
    }

    /**
     * Return number of displayed clients from user settings.
     *
     * @return mixed
     */
    public static function displayedClients() {
        $settings = Auth::user()->settings()->first();

        // Make sure displayed clients exists
        if (!$settings) {
            return 10;
        }
        return $settings->displayed_clients;
    }

    /**
     * Return number of displayed products from user settings.
     *
     * @return mixed
     */
    public static function displayedProducts() {
        $settings = Auth::user()->settings()->first();

        // Make sure displayed products exists
        if (!$settings) {
            return 10;
        }
        return $settings->displayed_products;
    }

    /**
     * Return number of displayed custom products from user settings.
     *
     * @return mixed
     */
    public static function displayedCustomProducts() {
        $settings = Auth::user()->settings()->first();

        // Make sure displayed custom products exists
        if (!$settings) {
            return 10;
        }
        return $settings->displayed_custom_products;
    }

    /**
     * Return user language key.
     *
     * @return mixed
     */
    public static function language() {
        $language = Auth::user()->settings()->leftJoin('languages', 'language_id', '=', 'languages.id')->first();
        if ($language) {
            return $language->key;
        }
        return 'en';
    }

    /**
     * @return mixed
     */
    public static function defaultLanguageId() {
        $language = Language::select('id')->where('key', 'ro')->first();
        return $language->id;
    }

    /**
     * Return user displayed bills, clients, products and custom products.
     *
     * @return array
     */
    public static function all() {
        $settings = Auth::user()->settings()->first();
        return [
            'displayed_bills' => $settings->displayed_bills,
            'displayed_clients' => $settings->displayed_clients,
            'displayed_products' => $settings->displayed_products,
            'displayed_custom_products' => $settings->displayed_custom_products
        ];
    }

}