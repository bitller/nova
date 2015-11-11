<?php

namespace App\Http\Controllers\AdminCenter;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfDisplayedBillsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfDisplayedClientsRequest;
use App\Http\Requests\AdminCenter\ApplicationSettings\EditNumberOfDisplayedProductsRequest;
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
        $securitySettings = SecuritySetting::select('recover_code_valid_minutes', 'login_attempts', 'allow_new_accounts')->first();

        // Build settings array manually
        $settings = [
            'displayed_bills' => $userDefaultSettings->displayed_bills,
            'displayed_clients' => $userDefaultSettings->displayed_clients,
            'displayed_products' => $userDefaultSettings->displayed_products,
            'displayed_custom_products' => $userDefaultSettings->displayed_custom_products,
            'recover_code_valid_minutes' => $securitySettings->recover_code_valid_minutes,
            'login_attempts' => $securitySettings->login_attempts,
        ];

        if ($securitySettings->allow_new_accounts) {
            $settings['allow_new_accounts'] = trans('common.yes');
        } else {
            $settings['allow_new_accounts'] = trans('common.no');
        }

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
}