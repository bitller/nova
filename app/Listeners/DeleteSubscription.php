<?php

namespace App\Listeners;

use App\Events\SubscriptionDeleted;
use App\Subscription;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * DeleteSubscription listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteSubscription {

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
     * @param  SubscriptionDeleted  $event
     * @return void
     */
    public function handle(SubscriptionDeleted $event) {

        // Stop event propagation if subscription does not exists
        if ($event->userId) {
            return false;
        }

        Subscription::where('paymill_subscription_id', $event->subscription['id'])->delete();
    }
}
