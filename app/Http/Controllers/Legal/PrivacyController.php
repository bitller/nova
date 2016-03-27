<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\BaseController;

/**
 * Handle privacy page.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PrivacyController extends BaseController {

    /**
     * Render privacy page.
     * 
     * @return mixed
     */
    public function index() {
        return view('pages.legal.privacy');
    }
    
}