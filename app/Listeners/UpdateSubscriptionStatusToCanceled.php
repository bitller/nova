<?php

namespace App\Listeners;

use App\Events\SubscriptionCanceled;
use App\Subscription;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * UpdateSubscriptionStatusToCanceled listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UpdateSubscriptionStatusToCanceled {

    /**
     * Create the event listener.
     *
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SubscriptionCanceled  $event
     * @return void
     */
    public function handle(SubscriptionCanceled $event) {

        // Stop event propagation if subscription does not exists
        if (!$event->userId) {
            return false;
        }

        Subscription::where('paymill_subscription_id', $event->subscription['id'])->update(['status' => 'canceled']);
    }
}
