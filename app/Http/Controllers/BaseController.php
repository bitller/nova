<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use App\Helpers\Settings;

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
        App::setLocale(Settings::language());
    }

}