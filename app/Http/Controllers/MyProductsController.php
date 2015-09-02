<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Handle work with products added by users
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MyProductsController extends Controller {

    /**
     * Initialize required stuff
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('my-products');
    }

    public function getProducts() {
        //
    }

}