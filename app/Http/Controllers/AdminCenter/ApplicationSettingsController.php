<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;

/**
 * Handle application settings.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ApplicationSettingsController extends BaseController {

    /**
     * Only application admin has access.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render application settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('admin-center.application-settings');
    }
}