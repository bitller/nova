<?php

namespace App\Http\Controllers;

use App\Helpers\UserActions;
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

        $data = $request->all();
        $data = (array) $data;
        $event = $data['event'];
        $eventType = $event['event_type'];

        $eventResource = $event['event_resource'];

        if ($eventType === 'subscription.failed') {
            $a = new Webhook();
            $a->status = $eventType;
            $a->obj = json_encode($event);
            $a->save();
        }

        // Handle subscription created event
        if ($eventType === 'subscription.created') {
            // Get user id
            $subscriptionDetails = Subscription::where('paymill_subscription_id', $eventResource['id'])->first();
            // Log
            UserActions::info($subscriptionDetails->user_id, 'Subscription id ' . $eventResource['id'] . ' created.');
        }

        // Handle subscription succeeded event
        if ($eventType === 'subscription.succeeded') {
            // Get user id and log action
            $subscription = $eventResource['subscription'];
            $subscriptionDetails = Subscription::where('paymill_subscription_id', $subscription['id'])->first();
            UserActions::info($subscriptionDetails->user_id, 'Subscription succeeded with id ' . $subscription['id'] . ' succeeded.');

            // Update database
            Subscription::where('paymill_subscription_id', $subscription['id'])->update([
                'is_active' => 1,
                'waiting_for_paymill' => 0
            ]);
        }

        // Handle subscription failed event
        if ($eventType === 'subscription.failed') {

            // Get user id
            $subscription = $eventResource['subscription'];
            $subscriptionDetails = Subscription::where('paymill_subscription_id', $subscription['id'])->first();

            // Log to user actions
            UserActions::info($subscriptionDetails->user_id, 'Subscription with id ' . $subscription['id'] . ' failed.');

            // Update database
            Subscription::where('paymill_subscription_id', $subscription['id'])->update([
                'is_active' => 0,
                'waiting_for_paymill' => 0
            ]);
        }
    }
}