<?php

namespace App\Http\Controllers\AdminCenter\Subscriptions;

use App\Http\Controllers\BaseController;

/**
 * Handle subscriptions management.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionsController extends BaseController {

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
        return view('admin-center.subscriptions.index');
    }

}