<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\SupportCenter\GetIndexPageDataRequest;

/**
 * Handle users support requests.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SupportCenterController extends BaseController {

    /**
     * Allow only admin.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('support-center.index');
    }

    public function get(GetIndexPageDataRequest $request) {
        //
    }

}