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
//        $event = json_decode($request->all());
//        $event = $event['event'];
//        $eventType = $event['event_type'];
//        $eventResource = $event['event_resource'];

        $b = new Webhook();
        $b->status = 'called';
        $b->save();

        $data = $request->all();

        $a = new Webhook();
        $a->obj = json_encode($data['event_resource']);
        $a->save();

//        $h = new Webhook();

//        $data = $request->json('event');

//        $h->obj = $data['event_resource'];
//        $h->obj = $request->json()->all();
//        $s = $eventResource['subscription'];
//        $h->obj = $eventResource['subscription'];
//        $h->obj = $eventResource['subscription']['id'];
//        $h->save();

        // Handle case when subscription is active
//        if ($eventType === 'subscription.succeeded') {
//            Subscription::where('paymill_subscription_id' === $eventResource['subscription']['id'])->update([
//                'is_active' => 1,
//                'waiting_for_paymill' => 0
//            ]);
//        }
    }
}