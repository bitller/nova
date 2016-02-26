<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AjaxResponse;
use App\Helpers\PermissionsHelper;
use App\Helpers\Roles;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use App\Offer;
use App\TrialPeriod;
use App\User;
use App\UserSetting;
use App\UserTrialPeriod;
use Paymill\Request as PaymillRequest;
use App\Payment as PaymentModel;
use App\Subscription as SubscriptionModel;
use Paymill\Models\Request\Payment;
use Paymill\Models\Request\Subscription;
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

        $data = [
            'allowNewUsers' => false
        ];

        if (PermissionsHelper::newUsers()) {
            $data['allowNewUsers'] = true;
        }

        return view('auth.register')->with($data);

    }

    /**
     * Create new account.
     *
     * @param CreateAccountRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function register(CreateAccountRequest $request) {

        $response = new AjaxResponse();
        $roles = new Roles();

        // Build user data array
        $data = [
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role_id' => $roles->getUserRoleId()
        ];

        // Insert user
        $user = User::create($data);

        // User settings
        UserSetting::insert([
            'user_id' => $user->id,
            'language_id' => Settings::defaultLanguageId()
        ]);

        // Create trial period
        UserTrialPeriod::create([
            'user_id' => $user->id,
            'trial_period_id' => TrialPeriod::first()->id
        ]);

        Auth::login($user);

        $response->setSuccessMessage(trans('register.account_created'));
        return response($response->get());

    }

}