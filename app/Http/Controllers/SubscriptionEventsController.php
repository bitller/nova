<?php

namespace App\Http\Controllers;

use App\Events\SubscriptionCanceled;
use App\Events\SubscriptionCreated;
use App\Events\SubscriptionDeleted;
use App\Events\SubscriptionFailed;
use App\Events\SubscriptionSucceeded;
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
            event(new SubscriptionCreated($eventResource));
        }

        // Handle subscription succeeded event
        if ($eventType === 'subscription.succeeded') {
            event(new SubscriptionSucceeded($eventResource['subscription'], $eventResource['transaction']));
        }

        // Handle subscription failed event
        if ($eventType === 'subscription.failed') {
            event(new SubscriptionFailed($eventResource['subscription'], $eventResource['transaction']));
        }

        // Handle subscription canceled event
        if ($eventType === 'subscription.canceled') {
            event(new SubscriptionCanceled($eventResource['subscription']));
        }

        // Handle subscription deleted event
        if ($eventType === 'subscription.deleted') {
            event(new SubscriptionDeleted($eventResource));
        }

        // Handle subscription updated event
        if ($eventType === 'subscription.updated') {
//            $eventResource['id'];
        }

        return response('Success.', 200);
    }
}