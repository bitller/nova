<?php

namespace App\Http\Controllers\AdminCenter\Subscriptions;

use App\Http\Controllers\BaseController;
use App\Subscription;

/**
 * Handle subscriptions management.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionsController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin-center.subscriptions.index');
    }

    /**
     * Paginate subscriptions.
     *
     * @param $status
     * @return mixed
     */
    public function get($status) {

        // Make sure given status is allowed
        $allowedStatuses = ['active', 'canceled', 'failed', 'waiting'];
        if (!in_array($status, $allowedStatuses)) {
            $status = 'active';
        }

        $query = Subscription::where('subscriptions.status', $status)
            ->leftJoin('users', 'users.id', '=', 'subscriptions.user_id')
            ->leftJoin('transactions', 'transactions.subscription_id', '=', 'subscriptions.id')
            ->paginate();
        return $query;
    }

}