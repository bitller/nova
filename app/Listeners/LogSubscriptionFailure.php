<?php

namespace App\Listeners;

use App\Events\SubscriptionFailed;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogSubscriptionFailure listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogSubscriptionFailure {

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

        UserActions::info($event->userId, 'Subscription with id ' . $event->subscription['id'] . ' failed.');
    }
}
