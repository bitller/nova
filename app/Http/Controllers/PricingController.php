<?php

namespace App\Http\Controllers;

/**
 * Handle prices page.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PricingController extends BaseController {

    /**
     * Render prices page.
     *
     * @return mixed
     */
    public function index() {
        return view('pages.pricing.index');
    }

}