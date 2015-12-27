<?php

namespace App\Http\Controllers\AdminCenter\Subscriptions;

use App\Http\Controllers\BaseController;

/**
 * Allow admin to create, edit and delete offers.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class OffersController extends BaseController {

    /**
     * Allow only admin.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin-center.subscriptions.offers');
    }

}