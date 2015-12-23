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
        $event = (array) $request->get('event');
        $eventType = $event['event_type'];
        $eventResource = $event['event_resource'];
        $h = new Webhook();
        $h->status = 'called';
        $h->obj = $eventResource['subscription']['id'];
        $h->save();

        // Handle case when subscription is active
        if ($eventType === 'subscription.succeeded') {
            Subscription::where('paymill_subscription_id' === $eventResource['subscription']['id'])->update([
                'is_active' => 1,
                'waiting_for_paymill' => 0
            ]);
        }
    }
}