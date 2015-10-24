<?php

namespace App\Http\Controllers;

use App\Helpers\AjaxResponse;
use App\Http\Requests\Settings\EditUserEmailRequest;
use App\Http\Requests\Settings\EditUserPasswordRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Allow user to change application settings.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmai.com>
 */
class SettingsController extends Controller {

    /**
     * Initialize required stuff.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Render index page.
     */
    public function index() {
        return view('settings');
    }

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

        User::where('id', Auth::user()->id)->update(['password' => bcrypt($request->get('new_password'))]);

        $response->setSuccessMessage(trans('settings.password_updated'));
        return response($response->get());

    }

    public function editNumberOfDisplayedBills() {
        //
    }

    public function editNumberOfDisplayedClients() {
        //
    }

    public function editNumberOfDisplayedProducts() {
        //
    }

    public function editNumberOfDisplayedApplicationProducts() {
        //
    }

    public function changeLanguage() {
        //
    }

}
