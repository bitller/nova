<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AjaxResponse;
use App\Helpers\Roles;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use App\User;
use App\UserSetting;
use Illuminate\Support\Facades\Auth;

/**
 * Handle user registration
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RegisterController extends Controller {

    /**
     * Allow only not logged in users.
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Render register page.
     *
     * @return string
     */
    public function index() {
        return view('auth.register');
    }

    /**
     * Create new account.
     *
     * @param CreateAccountRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function register(CreateAccountRequest $request) {

        $roles = new Roles();
        // Build user data array
        $data = array_merge($request->all(), ['role_id' => $roles->getUserRoleId()]);

        // Insert user
        $user = User::create($data);

        // User settings
        UserSetting::insert([
            'user_id' => $user->id,
            'language_id' => Settings::defaultLanguageId()
        ]);

        Auth::login($user);

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('register.account_created'));
        return response($response->get());

    }

}