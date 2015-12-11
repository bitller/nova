<?php

namespace App\Http\Controllers;

/**
 * Handle new registered users.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NextController extends BaseController {

    /**
     * Allow logged in users only.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('next');
    }

}