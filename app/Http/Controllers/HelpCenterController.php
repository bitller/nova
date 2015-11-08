<?php

namespace App\Http\Controllers;

/**
 * Handle help center.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class HelpCenterController extends BaseController {

    /**
     * Allow only logged in users.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Render help center index.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('help-center.index');
    }

}