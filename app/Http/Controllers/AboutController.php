<?php

namespace App\Http\Controllers;

/**
 * Handle about page.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AboutController extends BaseController {

    /**
     * Allow only logged in users.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('about');
    }

}