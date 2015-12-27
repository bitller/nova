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

        if ($eventType === 'subscription.updated') {
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
                'status' => 'active'
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
                'status' => 'failed'
            ]);
        }

        // Handle subscription canceled event
        if ($eventType === 'subscription.canceled') {

            // Get user id
            $subscriptionDetails = Subscription::where('paymill_subscription_id', $eventResource['id'])->first();

            // Log user action
            UserActions::info($subscriptionDetails->user_id, 'Subscription with id ' . $eventResource['id'] . ' was canceled.');

            // Update database
            Subscription::where('paymill_subscription_id', $eventResource['id'])->update([
                'status' => 'canceled'
            ]);
        }

        // Handle subscription deleted event
        if ($eventType === 'subscription.deleted') {

            // Get user id
            $subscriptionDetails = Subscription::where('paymill_subscription_id', $eventResource['id'])->first();

            // Log action
            UserActions::info($subscriptionDetails->user_id, 'Subscription with id ' . $eventResource['id'] . ' was deleted.');

            // Delete also from database
            Subscription::where('paymill_subscription_id', $eventResource['id'])->delete();
        }

        // Handle subscription updated event
        if ($eventType === 'subscription.updated') {
//            $eventResource['id'];
        }

        return response('Success.', 200);
    }
}