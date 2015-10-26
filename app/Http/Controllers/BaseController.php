<?php

namespace App\Http\Controllers;

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
        $this->middleware('language');
    }

}