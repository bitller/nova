<?php

namespace App\Http\Controllers\AdminCenter;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\ApplicationSettings\AllowCreationOfNewAccountsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\AllowUsersToChangeLanguageRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\DenyCreationOfNewAccountsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\DenyUsersToChangeLanguageRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfDisplayedBillsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfDisplayedClientsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfDisplayedCustomProductsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfDisplayedProductsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfLoginAttemptsAllowedRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditRecoverCodeValidTimeRequest;
use App\SecuritySetting;
use App\UserDefaultSetting;

/**
 * Handle application settings.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ApplicationSettingsController extends BaseController {

    /**
     * Only application admin has access.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render application settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('admin-center.application-settings');
    }

    /**
     * @return mixed
     */
    public function get() {

        $userDefaultSettings = UserDefaultSetting::select('displayed_bills', 'displayed_clients', 'displayed_products', 'displayed_custom_products')->first();
        $securitySettings = SecuritySetting::select('recover_code_valid_minutes', 'login_attempts', 'allow_new_accounts', 'allow_users_to_change_language')->first();

        // Build settings array manually
        $settings = [
            'displayed_bills' => $userDefaultSettings->displayed_bills,
            'displayed_clients' => $userDefaultSettings->displayed_clients,
            'displayed_products' => $userDefaultSettings->displayed_products,
            'displayed_custom_products' => $userDefaultSettings->displayed_custom_products,
            'recover_code_valid_minutes' => $securitySettings->recover_code_valid_minutes,
            'login_attempts' => $securitySettings->login_attempts,
        ];

        // Allow new accounts setting
        if ($securitySettings->allow_new_accounts) {
            $settings['allow_new_accounts'] = trans('common.yes');
            $allowNewAccounts = true;
        } else {
            $settings['allow_new_accounts'] = trans('common.no');
            $allowNewAccounts = false;
        }

        // Allow users to change language setting
        if ($securitySettings->allow_users_to_change_language) {
            $settings['allow_users_to_change_language'] = trans('common.yes');
            $allowUsersToChangeLanguage = true;
        } else {
            $settings['allow_users_to_change_language'] = trans('common.no');
            $allowUsersToChangeLanguage = false;
        }

        $settings['allow_new_accounts_bool'] = $allowNewAccounts;
        $settings['allow_users_to_change_language_bool'] = $allowUsersToChangeLanguage;

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields($settings);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * @param EditNumberOfDisplayedBillsRequest $request
     * @return mixed
     */
    public function editNumberOfDisplayedBills(EditNumberOfDisplayedBillsRequest $request) {

        $userDefaultSetting = UserDefaultSetting::first();
        $userDefaultSetting->displayed_bills = $request->get('displayed_bills');
        $userDefaultSetting->save();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.displayed_bills_updated'));
        $response->addExtraFields(['displayed_bills' => $userDefaultSetting->displayed_bills]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit default number of clients displayed.
     *
     * @param EditNumberOfDisplayedClientsRequest $request
     * @return mixed
     */
    public function editNumberOfDisplayedClients(EditNumberOfDisplayedClientsRequest $request) {

        // Update value in database
        $userDefaultSetting = UserDefaultSetting::first();
        $userDefaultSetting->displayed_clients = $request->get('displayed_clients');
        $userDefaultSetting->save();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.displayed_clients_updated'));
        $response->addExtraFields(['displayed_clients' => $userDefaultSetting->displayed_clients]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit default number of products displayed.
     *
     * @param EditNumberOfDisplayedProductsRequest $request
     * @return mixed
     */
    public function editNumberOfDisplayedProducts(EditNumberOfDisplayedProductsRequest $request) {

        // Update value in database
        $userDefaultSetting = UserDefaultSetting::first();
        $userDefaultSetting->displayed_products = $request->get('displayed_products');
        $userDefaultSetting->save();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.displayed_products_updated'));
        $response->addExtraFields(['displayed_products' => $userDefaultSetting->displayed_products]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit default number of custom products displayed.
     *
     * @param EditNumberOfDisplayedCustomProductsRequest $request
     * @return mixed
     */
    public function editNumberOfDisplayedCustomProducts(EditNumberOfDisplayedCustomProductsRequest $request) {

        // Update database
        $userDefaultSetting = UserDefaultSetting::first();
        $userDefaultSetting->displayed_custom_products = $request->get('displayed_custom_products');
        $userDefaultSetting->save();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.displayed_custom_products_updated'));
        $response->addExtraFields(['displayed_custom_products' => $userDefaultSetting->displayed_custom_products]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Set how many minutes recover code is valid.
     *
     * @param EditRecoverCodeValidTimeRequest $request
     * @return mixed
     */
    public function editRecoverCodeValidTime(EditRecoverCodeValidTimeRequest $request) {

        // Update table
        $securitySetting = SecuritySetting::first();
        $securitySetting->recover_code_valid_minutes = $request->get('recover_code_valid_minutes');
        $securitySetting->save();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.recover_code_updated'));
        $response->addExtraFields(['recover_code_valid_minutes' => $securitySetting->recover_code_valid_minutes]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Change number of consecutive login attempts allowed.
     *
     * @param EditNumberOfLoginAttemptsAllowedRequest $request
     * @return mixed
     */
    public function editNumberOfLoginAttemptsAllowed(EditNumberOfLoginAttemptsAllowedRequest $request) {

        // Update in database
        $securitySetting = SecuritySetting::first();
        $securitySetting->login_attempts = $request->get('login_attempts');
        $securitySetting->save();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.number_of_login_attempts_updated'));
        $response->addExtraFields(['login_attempts' => $securitySetting->login_attempts]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow creation of new accounts.
     *
     * @param AllowCreationOfNewAccountsRequest $request
     * @return mixed
     */
    public function allowCreationOfNewAccounts(AllowCreationOfNewAccountsRequest $request) {

        $securitySetting = SecuritySetting::first();
        $securitySetting->allow_new_accounts = 1;
        $securitySetting->save();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.new_accounts_are_allowed'));
        $response->addExtraFields([
            'allow_new_accounts' => trans('common.yes'),
            'allow_new_accounts_bool' => true
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * @param DenyCreationOfNewAccountsRequest $request
     * @return mixed
     */
    public function denyCreationOfNewAccounts(DenyCreationOfNewAccountsRequest $request) {

        $securitySetting = SecuritySetting::first();
        $securitySetting->allow_new_accounts = 0;
        $securitySetting->save();

        // Return response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.new_accounts_are_not_allowed'));
        $response->addExtraFields([
            'allow_new_accounts' => trans('common.no'),
            'allow_new_accounts_bool' => false
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * @param AllowUsersToChangeLanguageRequest $request
     * @return mixed
     */
    public function allowUsersToChangeLanguage(AllowUsersToChangeLanguageRequest $request) {

        $securitySetting = SecuritySetting::first();
        $securitySetting->allow_users_to_change_language = 1;
        $securitySetting->save();

        // Success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.users_are_allowed_to_change_language'));
        $response->addExtraFields([
            'allow_users_to_change_language' => trans('common.yes'),
            'allow_users_to_change_language_bool' => true
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * @param DenyUsersToChangeLanguageRequest $request
     * @return mixed
     */
    public function denyUsersToChangeLanguage(DenyUsersToChangeLanguageRequest $request) {

        $securitySetting = SecuritySetting::first();
        $securitySetting->allow_users_to_change_language = 0;
        $securitySetting->save();

        // Success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('application_settings.users_are_not_allowed_to_change_language'));
        $response->addExtraFields([
            'allow_users_to_change_language' => trans('common.no'),
            'allow_users_to_change_language_bool' => false
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

}