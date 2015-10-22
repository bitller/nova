<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        //
    }

    public function editEmail() {
        //
    }

    public function editPassword() {
        //
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
