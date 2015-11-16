<?php

namespace App\Http\Controllers\AdminCenter;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\UsersManager\GetIndexDataRequest;
use App\User;

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
        $this->middleware('admin');
    }

    /**
     * Render users manager index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('admin-center.users-manager');
    }

    /**
     * Return index page data.
     *
     * @param GetIndexDataRequest $request
     * @return mixed
     */
    public function get(GetIndexDataRequest $request) {

        // Basic data array
        $data = [
            'registered_users' => User::count(),
            'confirmed_users' => User::where('confirmed', 1)->count(),
            'users_registered_today' => User::registeredToday()->count(),
        ];

        $data['not_confirmed_users'] = $data['registered_users'] - $data['confirmed_users'];
        $data['confirmed_users_percentage'] = ($data['confirmed_users'] / $data['registered_users']) * 100;
        $data['not_confirmed_users_percentage'] = 100 - $data['confirmed_users_percentage'];
        $data['users_registered_today_percentage'] = ($data['users_registered_today'] / $data['registered_users']) * 100;

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields($data);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function browse() {
        return view('admin-center.browse-users');
    }

}