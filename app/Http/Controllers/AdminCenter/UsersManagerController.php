<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;

/**
 * Manage application users.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UsersManagerController extends BaseController {

    /**
     * Allow only logged in users with moderator or higher level.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('moderator');
    }

    /**
     * Render users manager index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('admin-center.users-manager');
    }

    public function get() {
        //
    }

    /**
     * @return \Illuminate\View\View
     */
    public function browse() {
        return view('admin-center.browse-users');
    }

}