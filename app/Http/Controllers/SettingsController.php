<?php

namespace App\Http\Controllers;

use App\Helpers\AjaxResponse;
use App\Helpers\PermissionsHelper;
use App\Helpers\Settings;
use App\Http\Requests\Settings\ChangeLanguageRequest;
use App\Http\Requests\Settings\EditNumberOfDisplayedBillsRequest;
use App\Http\Requests\Settings\EditNumberOfDisplayedClientsRequest;
use App\Http\Requests\Settings\EditNumberOfDisplayedCustomProductsRequest;
use App\Http\Requests\Settings\EditNumberOfDisplayedProductsRequest;
use App\Http\Requests\Settings\EditUserEmailRequest;
use App\Http\Requests\Settings\EditUserPasswordRequest;
use App\Language;
use App\User;
use App\UserDefaultSetting;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Allow user to change application settings.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmai.com>
 */
class SettingsController extends BaseController {

    /**
     * Initialize required stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render index page.
     */
    public function index() {

        $data = [
            'allowUserToChangeLanguage' => false
        ];

        if (PermissionsHelper::changeLanguage()) {
            $data['allowUserToChangeLanguage'] = true;
        }

        return view('settings')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function get() {

        $response = new AjaxResponse();

        $settings = Auth::user()->settings()->public()->first();
        $settings->email = Auth::user()->email;

        $response->addExtraFields(['data' => $settings]);
        $response->setSuccessMessage('bau');
        return response($response->get());

    }

    /**
     * Edit user email.
     *
     * @param EditUserEmailRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editEmail(EditUserEmailRequest $request) {

        $response = new AjaxResponse();

        // Check if email is already taken
        if (User::where('email', $request->get('email'))->count()) {
            $response->setFailMessage(trans('settings.email_already_used'));
            return response($response->get(), $response->getDefaultErrorResponseCode());
        }

        User::where('id', Auth::user()->id)->update(['email' => $request->get('email')]);

        $response->setSuccessMessage(trans('settings.email_updated'));
        $response->addExtraFields(['email' => $request->get('email')]);
        return response($response->get());

    }

    /**
     * Edit user password.
     *
     * @param EditUserPasswordRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editPassword(EditUserPasswordRequest $request) {

        $response = new AjaxResponse();

        // Check if current password is ok
        if (!Hash::check($request->get('password'), Auth::user()->password)) {
            $response->setFailMessage(trans('settings.invalid_password'));
            return response($response->get(), $response->getDefaultErrorResponseCode());
        }

        User::where('id', Auth::user()->id)->update(['password' => bcrypt($request->get('new_password'))]);

        $response->setSuccessMessage(trans('settings.password_updated'));
        return response($response->get());

    }

    /**
     * Edit number of displayed bills.
     *
     * @param EditNumberOfDisplayedBillsRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editNumberOfDisplayedBills(EditNumberOfDisplayedBillsRequest $request) {

        $response = new AjaxResponse();

        Auth::user()->settings()->update(['displayed_bills' => $request->get('bills_to_display')]);
        $settings = Auth::user()->settings()->first();

        $response->setSuccessMessage(trans('settings.number_of_displayed_bills_updated'));
        $response->addExtraFields(['displayed_bills' => $settings->displayed_bills]);
        return response($response->get());

    }

    /**
     * Edit number of displayed clients.
     *
     * @param EditNumberOfDisplayedClientsRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editNumberOfDisplayedClients(EditNumberOfDisplayedClientsRequest $request) {

        $response = new AjaxResponse();

        Auth::user()->settings()->update(['displayed_clients' => $request->get('clients_to_display')]);
        $settings = Auth::user()->settings()->first();

        $response->setSuccessMessage(trans('settings.number_of_displayed_clients_updated'));
        $response->addExtraFields(['displayed_clients' => $settings->displayed_clients]);
        return response($response->get());

    }

    /**
     * Edit number of displayed products.
     *
     * @param EditNumberOfDisplayedProductsRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editNumberOfDisplayedProducts(EditNumberOfDisplayedProductsRequest $request) {

        $response = new AjaxResponse();

        Auth::user()->settings()->update(['displayed_products' => $request->get('products_to_display')]);
        $settings = Auth::user()->settings()->first();

        $response->setSuccessMessage(trans('settings.number_of_displayed_products_updated'));
        $response->addExtraFields(['displayed_products' => $settings->displayed_products]);
        return response($response->get());

    }

    /**
     * Edit number of custom products displayed.
     *
     * @param EditNumberOfDisplayedCustomProductsRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editNumberOfDisplayedCustomProducts(EditNumberOfDisplayedCustomProductsRequest $request) {

        $response = new AjaxResponse();

        Auth::user()->settings()->update(['displayed_custom_products' => $request->get('custom_products_to_display')]);
        $settings = Auth::user()->settings()->first();

        $response->setSuccessMessage(trans('settings.number_of_displayed_custom_products_updated'));
        $response->addExtraFields(['displayed_custom_products' => $settings->displayed_custom_products]);
        return response($response->get());

    }

    /**
     * Change application language.
     *
     * @param ChangeLanguageRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function changeLanguage(ChangeLanguageRequest $request) {

        $response = new AjaxResponse();

        $language = Language::where('key', $request->get('language'))->first();

        Auth::user()->settings()->update(['language_id' => $language->id]);

        $response->setSuccessMessage(trans('settings.language_changed'));
        $response->addExtraFields(['language' => $language->language]);
        return response($response->get());

    }

    public function getLanguages() {

        $response = new AjaxResponse();

        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields(['languages' => Language::select('key', 'language')->get()]);
        return response($response->get());
    }

    /**
     * Reset user settings to default.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resetToDefaultValues() {

        $response = new AjaxResponse();
        $defaultSettings = UserDefaultSetting::first();

        Auth::user()->settings()->update([
            'displayed_bills' => $defaultSettings->displayed_bills,
            'displayed_clients' => $defaultSettings->displayed_clients,
            'displayed_products' => $defaultSettings->displayed_products,
            'displayed_custom_products' => $defaultSettings->displayed_custom_products
        ]);

        $response->setSuccessMessage(trans('settings.restored_to_default_settings'));
        $response->addExtraFields(Settings::all());
        return response($response->get());

    }

}
