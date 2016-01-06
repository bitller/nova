<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AjaxResponse;
use App\Helpers\PermissionsHelper;
use App\Helpers\Roles;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use App\Offer;
use App\User;
use App\UserSetting;
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

        Auth::login($user);

        // Try to create subscription
        $privateKey = 'cf803e2147fd65a0d2a6b3d5afbfa9af';
        $paymillRequest = new PaymillRequest($privateKey);

        // Create credit card payment
        $payment = new Payment();
        $payment->setToken($request->get('token'));
        $paymentResponse = $paymillRequest->create($payment);

        // Get offer
        $offer = Offer::where('use_on_sign_up', true)->first();



        // Create subscription
        $subscription = new Subscription();
        $subscription->setAmount(30)
            ->setPayment($paymentResponse->getId())
            ->setOffer($offer->paymill_offer_id)
            ->setPeriodOfValidity('2 YEAR')
            ->setStartAt(time() + 30);

        $subscriptionResponse = $paymillRequest->create($subscription);

        // Save in database
        $paymentModel = new PaymentModel();
        $paymentModel->user_id = Auth::user()->id;
        $paymentModel->paymill_payment_id = $paymentResponse->getId();
        $paymentModel->save();

        // Save subscription
        $subscriptionModel = new SubscriptionModel();
        $subscriptionModel->user_id = Auth::user()->id;
        $subscriptionModel->paymill_subscription_id = $subscriptionResponse->getId();
        $subscriptionModel->status = 'waiting';
        $subscriptionModel->save();

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('register.account_created'));
        return response($response->get());

    }

}