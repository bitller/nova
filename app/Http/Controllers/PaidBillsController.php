<?php

namespace App\Http\Controllers;

use App\Helpers\Bills;

/**
 * Handle user paid bills
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaidBillsController extends BaseController {

    /**
     * Initialize required stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render paid bills index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('paid-bills');
    }

    public function get() {


        return Bills::get(true);
    }

}