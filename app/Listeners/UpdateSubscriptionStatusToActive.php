<?php

namespace App\Listeners;

use App\Events\SubscriptionSucceeded;
use App\Subscription;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * UpdateSubscriptionStatusToSucceeded listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UpdateSubscriptionStatusToActive {

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
     * @param  SubscriptionSucceeded  $event
     * @return void
     */
    public function handle(SubscriptionSucceeded $event) {
        Subscription::where('paymill_subscription_id', $event->subscription['id'])->update(['status' => 'active']);
    }
}
