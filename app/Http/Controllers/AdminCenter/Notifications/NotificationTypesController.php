<?php

namespace App\Http\Controllers\AdminCenter\Notifications;

use App\Http\Controllers\BaseController;

/**
 * Allow admin to create, edit and delete notification types.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NotificationTypesController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        return view('admin-center.notifications.types');
    }

    public function get() {
        //
    }

    public function create() {
        //
    }
}