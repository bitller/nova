<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\BaseController;

/**
 * Handle imprint page.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ImprintController extends BaseController {

    /**
     * Render imprint page.
     *
     * @return mixed
     */
    public function index() {
        return view('pages.legal.imprint');
    }

}