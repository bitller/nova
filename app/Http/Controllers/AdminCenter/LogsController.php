<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;

/**
 * Handle work with logs.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogsController extends BaseController {

    public function index() {
        return view('logs');
    }

}