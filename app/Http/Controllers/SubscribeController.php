<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Subscribe\ProcessRequest;
use App\User;
use App\Payment as PaymentModel;
use App\Subscription as SubscriptionModel;
use Illuminate\Support\Facades\Auth;
use Paymill\Request as PaymillRequest;
use Paymill\Models\Request\Payment;
use Paymill\Models\Request\Subscription;

class SubscribeController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {

        return view('subscribe');
    }

    public function process(ProcessRequest $request) {

        // Initialize paymill request


        // Create credit card payment
        $payment = new Payment();
        $payment->setToken($request->get('token'));
        $paymentResponse = $paymillRequest->create($payment);

        // Create subscription
        $subscription = new Subscription();
        $subscription->setAmount(30)
            ->setPayment($paymentResponse->getId())
            ->setCurrency('EUR')
            ->setInterval('1 week,monday')
            ->setName('Nova sub')
            ->setPeriodOfValidity('2 YEAR')
            ->setStartAt(time());

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
        $subscriptionModel->save();

    }
}