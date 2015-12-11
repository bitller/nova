<?php

namespace App\Http\Controllers\AdminCenter;

use App\Bill;
use App\Helpers\AjaxResponse;
use App\Helpers\Bills;
use App\Helpers\Searches;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\UsersManager\GetIndexDataRequest;
use App\Http\Requests\AdminCenter\UsersManager\SearchUsersRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\DeleteAllUserBillsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\DeleteUserBillRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\GetUserBillsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\PaidBills\GetUserPaidBillsRequest;
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

    /**
     * Return users that match given email.
     *
     * @param SearchUsersRequest $request
     * @return mixed
     */
    public function search(SearchUsersRequest $request) {
        return Searches::searchUsers($request->get('email'));
    }

    public function user($userId) {
        return view('admin-center.users-manager.user')->with('userId', $userId);
    }

    /**
     * @param int $userId
     * @param GetUserBillsRequest $request
     * @return mixed
     */
    public function getUserBills($userId, GetUserBillsRequest $request) {
        return Bills::get(false, $userId);
    }

    /**
     * @param int $userId
     * @param GetUserPaidBillsRequest $request
     * @return mixed
     */
    public function getUserPaidBills($userId, GetUserPaidBillsRequest $request) {
        return Bills::get(true, $userId);
    }

    /**
     * Delete given bill of given user.
     *
     * @param int $userId
     * @param DeleteUserBillRequest $request
     * @return mixed
     */
    public function deleteUserBill($userId, DeleteUserBillRequest $request) {

        Bill::where('user_id', $userId)->where('id', $request->get('bill_id'))->delete();
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('users_manager.user_bill_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete all user bills.
     *
     * @param int $userId
     * @param DeleteAllUserBillsRequest $request
     * @return mixed
     */
    public function deleteAllUserBills($userId, DeleteAllUserBillsRequest $request) {

        Bill::where('user_id', $userId)->delete();
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('users_manager.all_user_bills_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

}