<?php

namespace App\Listeners;

use App\Events\SubscriptionFailed;
use App\Subscription;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * UpdateSubscriptionStatusToFailed listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UpdateSubscriptionStatusToFailed {

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
     * @param  SubscriptionFailed  $event
     * @return void
     */
    public function handle(SubscriptionFailed $event) {

        // Stop event propagation if subscription does not exists
        if (!$event->userId) {
            return false;
        }

        Subscription::where('paymill_subscription_id', $event->subscription['id'])->update(['status' => 'failed']);
    }
}
