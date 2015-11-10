<?php

namespace App\Http\Controllers\AdminCenter;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
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
}