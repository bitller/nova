<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use App\Helpers\Settings;
use Illuminate\Support\Facades\Auth;

/**
 * Base controller to be extended by rest of controllers
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BaseController extends Controller {

    /**
     * Initialize required stuff.
     */
    public function __construct() {
        if (Auth::check()) {
            App::setLocale(Settings::language());
        }
    }

}