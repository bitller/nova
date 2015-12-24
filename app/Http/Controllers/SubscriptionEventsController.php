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

        $data = $request->all();
        $data = (array) $data;
        $event = $data['event'];
        $eventType = $event['event_type'];

        $eventResource = $event['event_resource'];

//        if ($eventType === 'subscription.succeeded') {
            $a = new Webhook();
            $a->status = $eventType;
            $a->obj = json_encode($event);
            $a->save();
//        }

        if ($eventType === 'subscription.created') {
            Subscription::where('paymill_subscription_id', $eventResource['id'])->update([
                'is_active' => 1,
                'waiting_for_paymill' => 0
            ]);
        }

        if ($eventType === 'subscription.succeeded') {
            $subscription = $eventResource['subscription'];
            Subscription::where('paymill_subscription_id', $subscription['id'])->update([
                'is_active' => 1,
                'waiting_for_paymill' => 0
            ]);
        }
    }
}