<?php

namespace App\Http\Controllers;

/**
 * Allow user to start a subscription.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionController extends BaseController {

    /**
     * SubscriptionController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        return view('subscribe.index');
    }

    public function card() {
        return view('subscribe.card');
    }

    public function bank() {
        return view('subscribe.bank');
    }

    public function subscribe() {
        //
    }
}