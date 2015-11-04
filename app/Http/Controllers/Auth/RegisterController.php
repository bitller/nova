<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use App\User;

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

    public function register(CreateAccountRequest $request) {

        $user = User::create($request->all());

        $response = new AjaxResponse();
        $response->setSuccessMessage('created');
        return response($response->get());

    }

}