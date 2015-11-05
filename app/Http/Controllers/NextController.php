<?php

namespace App\Http\Controllers;

/**
 * Handle new registered users.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NextController extends BaseController {

    public function index() {
        return view('next');
    }

}