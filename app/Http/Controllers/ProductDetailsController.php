<?php

namespace App\Http\Controllers;

/**
 * Handle each product apart
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductDetailsController extends BaseController {

    /**
     * Render index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('product-details');
    }

    public function get($productCode) {
        //
    }

}