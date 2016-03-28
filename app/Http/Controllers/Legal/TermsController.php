<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\BaseController;

/**
 * Handle terms page.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class TermsController extends BaseController {

    /**
     * Render terms page.
     * 
     * @return mixed
     */
    public function index() {
        return view('pages.legal.terms');
    }
    
}