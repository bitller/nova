<?php

namespace App\Listeners;

use App\Events\SubscriptionCanceled;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class LogSubscriptionWasCanceled listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogSubscriptionWasCanceled {

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

        UserActions::info($event->userId, 'Subscription with id ' . $event->subscription['id'] . ' was canceled.');
    }
}
