<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;

/**
 * Handle paymill post requests.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionEventsController extends BaseController {

    public function index() {
        $request = new Request();

        // Handle case when subscription is active
        if ($request->get('status') === 'active') {
            Subscription::where('paymill_subscription_id' === $request->get('id'))->update([
                'is_active' => 1,
                'waiting_for_paymill' => 0
            ]);
        }
    }
}