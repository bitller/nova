<?php

namespace App\Http\Controllers;

use App\Helpers\Bills;

/**
 * Handle user paid bills
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaidBillsController extends BaseController {

    public function index() {
        return view('paid-bills');
    }

    public function get() {
        return Bills::get(true);
    }

}