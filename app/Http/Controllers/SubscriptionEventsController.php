<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Webhook;
use Illuminate\Http\Request;

/**
 * Handle paymill post requests.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionEventsController extends BaseController {

    public function index(Request $request) {
//        $hook = new Webhook();
//        $hook->status = 'called';
//        $hook->save();
        // Handle case when subscription is active
        if ($request->get('status') === 'active') {
            Subscription::where('paymill_subscription_id' === $request->get('id'))->update([
                'is_active' => 1,
                'waiting_for_paymill' => 0
            ]);
        }
        $webhook = new Webhook();
        $webhook->status = $request->get('id');
        $webhook->save();
    }
}