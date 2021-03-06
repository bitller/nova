<?php

namespace App\Http\Controllers\AdminCenter;

use App\Action;
use App\Bill;
use App\Client;
use App\Helpers\AjaxResponse;
use App\Helpers\Bills;
use App\Helpers\Roles;
use App\Helpers\Searches;
use App\Helpers\Settings;
use App\Helpers\UserActions;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\UsersManager\CreateNewUserRequest;
use App\Http\Requests\AdminCenter\UsersManager\GetIndexDataRequest;
use App\Http\Requests\AdminCenter\UsersManager\SearchUsersRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Actions\DeleteUserActionsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\DeleteAllUserBillsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\DeleteUserBillRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\DeleteUserPaidBillsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\DeleteUserUnpaidBillsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\GetUserBillsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\MakeAllUserBillsPaidRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\MakeAllUserBillsUnpaidRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\MakeUserBillPaidRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Bills\MakeUserBillUnpaidRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\ChangeUserPasswordRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Clients\DeleteUserClientRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Clients\DeleteUserClientsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\Clients\GetUserClientsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\CustomProducts\DeleteUserCustomProductRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\CustomProducts\DeleteUserCustomProductsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\CustomProducts\GetUserCustomProductsRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\DeleteUserAccountRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\DisableUserAccountRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\EditUserEmailRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\EnableUserAccountRequest;
use App\Http\Requests\AdminCenter\UsersManager\User\PaidBills\GetUserPaidBillsRequest;
use App\Product;
use App\Subscription;
use App\User;
use App\UserAction;
use App\UserSetting;
use Illuminate\Support\Facades\DB;

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
        return view('admin-center.users-manager.index');
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
     * Allow admin to create new user.
     *
     * @param CreateNewUserRequest $request
     * @return mixed
     */
    public function createNewUser(CreateNewUserRequest $request) {

        $roles = new Roles();

        $user = User::create([
            'email' => $request->get('new_user_email'),
            'password' => bcrypt($request->get('new_user_password')),
            'special_user' => (bool) $request->get('make_special_user'),
            'role_id' => $roles->getUserRoleId()
        ]);

        // Generate user settings
        UserSetting::insert([
            'user_id' => $user->id,
            'language_id' => Settings::defaultLanguageId()
        ]);

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('users_manager.user_created_successfully'));
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

    public function getUserData($userId) {

        $response = new AjaxResponse();

        if (DB::table('users')->where('id', $userId)->count()) {
            $response->setSuccessMessage(trans('common.success'));
            $response->addExtraFields([
                'user' => DB::table('users')->where('id', $userId)->select('email', 'active')->first()
            ]);
            return response($response->get())->header('Content-Type', 'application/json');
        }

        $response->setFailMessage(trans('common.error'));
        return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
    }

    /**
     * Get bills of given user.
     *
     * @param int $userId
     * @param GetUserBillsRequest $request
     * @return mixed
     */
    public function getUserBills($userId, GetUserBillsRequest $request) {

        if (!User::where('id', $userId)->count()) {
            $response = new AjaxResponse();
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        return Bills::get(false, $userId);
    }

    /**
     * Get clients of given user.
     *
     * @param int $userId
     * @param GetUserClientsRequest $request
     * @return mixed
     */
    public function getUserClients($userId, GetUserClientsRequest $request) {

        // Make sure user id exists
        if (!User::where('id', $userId)->count()) {
            $response = new AjaxResponse();
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        return \App\Helpers\AdminCenter\User::getClients($userId);
    }

    /**
     * @param int $userId
     * @param GetUserPaidBillsRequest $request
     * @return mixed
     */
    public function getUserPaidBills($userId, GetUserPaidBillsRequest $request) {

        // Make sure user exists
        if (!User::where('id', $userId)->count()) {
            $response = new AjaxResponse();
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        return Bills::get(true, $userId);
    }

    /**
     * Get custom products of a given user.
     *
     * @param int $userId
     * @param GetUserCustomProductsRequest $request
     * @return mixed
     */
    public function getUserCustomProducts($userId, GetUserCustomProductsRequest $request) {

        // Make sure user id exists in database
        if (!User::where('id', $userId)->count()) {
            $response = new AjaxResponse();
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        return \App\Helpers\AdminCenter\User::getCustomProducts($userId);
    }

    /**
     * Paginate user actions.
     *
     * @param int $userId
     * @param string $type
     * @return mixed
     */
    public function getUserActions($userId, $type) {
        // Make sure user id exists in database
        if (!User::where('id', $userId)->count()) {
            $response = new AjaxResponse();
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Paginate allowed user actions
        if ($type === 'allowed') {
            return UserActions::getAllowed($userId);
        }

        // Paginate info user actions
        if ($type === 'info') {
            return UserActions::getInfo($userId);
        }

        // Paginate wrong format user actions
        if ($type === 'wrong_format') {
            return UserActions::getWrongFormat($userId);
        }

        // Paginate not allowed user actions
        if ($type === 'not_allowed') {
            return UserActions::getNotAllowed($userId);
        }

        // By default return all user actions
        return UserActions::getAll($userId);
    }

    /**
     * Delete given bill of given user.
     *
     * @param int $userId
     * @param DeleteUserBillRequest $request
     * @return mixed
     */
    public function deleteUserBill($userId, DeleteUserBillRequest $request) {

        $response = new AjaxResponse();

        // Make sure user bill exists
        if (!Bill::where('user_id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.bill_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        Bill::where('user_id', $userId)->where('id', $request->get('bill_id'))->delete();
        $response->setSuccessMessage(trans('users_manager.user_bill_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Make user bill paid.
     *
     * @param $userId
     * @param MakeUserBillPaidRequest $request
     * @return mixed
     */
    public function makeUserBillPaid($userId, MakeUserBillPaidRequest $request) {

        $response = new AjaxResponse();

        // Make sure user exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Make sure bill belongs to this user
        if (!Bill::where('user_id', $userId)->where('id', $request->get('bill_id'))->count()) {
            $response->setFailMessage(trans('users_manager.bill_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        Bill::where('user_id', $userId)->where('id', $request->get('bill_id'))->update(['paid' => 1]);
        $response->setSuccessMessage(trans('users_manager.user_bill_is_paid'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Make user bill unpaid.
     *
     * @param int $userId
     * @param MakeUserBillUnpaidRequest $request
     * @return mixed
     */
    public function makeUserBillUnpaid($userId, MakeUserBillUnpaidRequest $request) {

        $response = new AjaxResponse();

        // Make sure user exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Make sure bill belongs to this user
        if (!Bill::where('user_id', $userId)->where('id', $request->get('bill_id'))->count()) {
            $response->setFailMessage(trans('users_manager.bill_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        Bill::where('user_id', $userId)->where('id', $request->get('bill_id'))->update(['paid' => 0]);
        $response->setSuccessMessage(trans('users_manager.user_bill_is_unpaid'));

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

        $response = new AjaxResponse();

        // Make sure user exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        Bill::where('user_id', $userId)->delete();
        $response->setSuccessMessage(trans('users_manager.all_user_bills_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete user unpaid bills.
     *
     * @param int $userId
     * @param DeleteUserUnpaidBillsRequest $request
     * @return mixed
     */
    public function deleteUserUnpaidBills($userId, DeleteUserUnpaidBillsRequest $request) {

        $response = new AjaxResponse();

        // Make sure user exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        Bill::where('user_id', $userId)->where('paid', 0)->delete();
        $response->setSuccessMessage(trans('users_manager.user_unpaid_bills_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete user paid bills.
     *
     * @param int $userId
     * @param DeleteUserPaidBillsRequest $request
     * @return mixed
     */
    public function deleteUserPaidBills($userId, DeleteUserPaidBillsRequest $request) {

        $response = new AjaxResponse();

        // Make sure user exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        Bill::where('user_id', $userId)->where('paid', 1)->delete();
        $response->setSuccessMessage(trans('users_manager.user_paid_bills_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Make paid all user bills.
     *
     * @param int $userId
     * @param MakeAllUserBillsPaidRequest $request
     * @return mixed
     */
    public function makeAllUserBillsPaid($userId, MakeAllUserBillsPaidRequest $request) {

        Bill::where('user_id', $userId)->update(['paid' => 1]);
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('users_manager.all_user_bills_are_paid'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Make unpaid all user bills.
     *
     * @param int $userId
     * @param MakeAllUserBillsUnpaidRequest $request
     * @return mixed
     */
    public function makeAllUserBillsUnpaid($userId, MakeAllUserBillsUnpaidRequest $request) {

        $response = new AjaxResponse();

        // Make sure user exists in database
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Make user bills as unpaid
        Bill::where('user_id', $userId)->update(['paid' => 0]);

        $response->setSuccessMessage(trans('users_manager.all_user_bills_are_unpaid'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow admin to delete all clients of a given user.
     *
     * @param int $userId
     * @param DeleteUserClientsRequest $request
     * @return mixed
     */
    public function deleteUserClients($userId, DeleteUserClientsRequest $request) {

        $response = new AjaxResponse();

        // Make sure user id exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Delete user clients
        Client::where('user_id', $userId)->delete();

        $response->setSuccessMessage(trans('users_manager.user_clients_deleted'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow admin to delete any client of given user.
     *
     * @param int $userId
     * @param DeleteUserClientRequest $request
     * @return mixed
     */
    public function deleteUserClient($userId, DeleteUserClientRequest $request) {

        $response = new AjaxResponse();

        // Make sure user id exists in database
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Make sure client belongs to current user
        if (!Client::where('user_id', $userId)->where('id', $request->get('client_id'))->count()) {
            $response->setFailMessage(trans('users_manager.client_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Delete client
        Client::where('user_id', $userId)->where('id', $request->get('client_id'))->delete();

        $response->setSuccessMessage(trans('users_manager.user_client_deleted'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow admin to delete user custom product.
     *
     * @param int $userId
     * @param DeleteUserCustomProductRequest $request
     * @return mixed
     */
    public function deleteUserCustomProduct($userId, DeleteUserCustomProductRequest $request) {

        $response = new AjaxResponse();

        // Make sure user id exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Make sure custom product belongs to current user
        if (!Product::where('user_id', $userId)->where('id', $request->get('custom_product_id'))->count()) {
            $response->setFailMessage(trans('users_manager.product_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Delete custom product
        Product::where('id', $request->get('custom_product_id'))->where('user_id', $userId)->delete();

        $response->setSuccessMessage(trans('users_manager.user_custom_product_deleted'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow admin to delete all user custom products.
     *
     * @param int $userId
     * @param DeleteUserCustomProductsRequest $request
     * @return mixed
     */
    public function deleteUserCustomProducts($userId, DeleteUserCustomProductsRequest $request) {

        $response = new AjaxResponse();

        // Make sure user id exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Delete custom products
        Product::where('user_id', $userId)->delete();

        $response->setSuccessMessage(trans('users_manager.user_custom_products_deleted'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete user actions.
     *
     * @param int $userId
     * @param string $type
     * @param DeleteUserActionsRequest $request
     * @return mixed
     */
    public function deleteUserActions($userId, $type, DeleteUserActionsRequest $request) {

        $response = new AjaxResponse();

        // Make sure user id exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        $typeUsedInQuery = false;

        if ($type === 'allowed' || $type === 'info' || $type === 'wrong_format' || $type === 'not_allowed') {
            $typeUsedInQuery = $type;
        }

        // Delete user actions
        if (!$typeUsedInQuery) {
            UserAction::where('user_id', $userId)->delete();
        } else {
            $action = Action::where('type', $type)->first();
            UserAction::where('user_id', $userId)->where('action_id', $action->id)->delete();
        }

        $response->setSuccessMessage(trans('users_manager.user_actions_deleted'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow admin to edit user email.
     *
     * @param int $userId
     * @param EditUserEmailRequest $request
     * @return mixed
     */
    public function editUserEmail($userId, EditUserEmailRequest $request) {

        $response = new AjaxResponse();
        $user = User::find($userId);

        // Make sure user exists
        if (!$user) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Do nothing if email is the same
        if ($user->email === $request->get('email')) {
            $response->setSuccessMessage(trans('users_manager.user_email_updated'));
            $response->addExtraFields(['email' => $user->email]);
            return response($response->get())->header('Content-Type', 'application/json');
        }

        // Check if email is already used by another user
        if (User::where('email', $request->get('email'))->count()) {
            $response->setFailMessage(trans('users_manager.email_already_used'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Update
        User::where('id', $userId)->update(['email' => $request->get('email')]);
        $response->setSuccessMessage(trans('users_manager.user_email_updated'));
        $response->addExtraFields(['email' => $request->get('email')]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow admin to change the password of a given user.
     *
     * @param int $userId
     * @param ChangeUserPasswordRequest $request
     * @return mixed
     */
    public function changeUserPassword($userId, ChangeUserPasswordRequest $request) {

        $response = new AjaxResponse();
        $user = User::find($userId);

        // Check if user exists
        if (!$user) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');
        }

        // Update password
        User::where('id', $userId)->update(['password' => bcrypt($request->get('new_password'))]);

        $response->setSuccessMessage(trans('users_manager.user_password_changed'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow admin to disable users accounts.
     *
     * @param int $userId
     * @param DisableUserAccountRequest $request
     * @return mixed
     */
    public function disableUserAccount($userId, DisableUserAccountRequest $request) {

        // Make sure user id exists
        if (!User::where('id', $userId)->count()) {
            $response = new AjaxResponse();
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        return \App\Helpers\AdminCenter\User::changeAccountStatus(0, $userId);
    }

    /**
     * Allow admin to enable users accounts.
     *
     * @param int $userId
     * @param EnableUserAccountRequest $request
     * @return mixed
     */
    public function enableUserAccount($userId, EnableUserAccountRequest $request) {

        // Make sure user exists
        if (!User::where('id', $userId)->count()) {
            $response = new AjaxResponse();
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        return \App\Helpers\AdminCenter\User::changeAccountStatus(1, $userId);
    }

    /**
     * Allow admin to delete user account.
     *
     * @param int $userId
     * @param DeleteUserAccountRequest $request
     * @return mixed
     */
    public function deleteUserAccount($userId, DeleteUserAccountRequest $request) {

        $response = new AjaxResponse();

        // Make sure user id exists
        if (!User::where('id', $userId)->count()) {
            $response->setFailMessage(trans('users_manager.user_not_found'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        Subscription::where('user_id', $userId)->delete();
        User::where('id', $userId)->delete();
        $response->setSuccessMessage(trans('users_manager.account_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

}