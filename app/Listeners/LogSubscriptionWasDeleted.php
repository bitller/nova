<?php

namespace App\Listeners;

use App\Events\SubscriptionDeleted;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogSubscriptionWasDeleted listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogSubscriptionWasDeleted {

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
        if (!$event->userId) {
            return false;
        }

        UserActions::info($event->userId, 'Subscription with id ' . $event->subscription['id'] . ' was deleted.');
    }
}
