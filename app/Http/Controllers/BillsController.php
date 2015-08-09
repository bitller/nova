<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Handle the work with bills
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('bills');
    }

}
