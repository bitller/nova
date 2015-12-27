<?php

namespace App\Listeners;

use App\Events\SubscriptionSucceeded;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogSubscriptionSucceeded listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogSubscriptionSucceeded {

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
        UserActions::info($event->userId, 'Subscription with id ' . $event->subscription['id'] . ' succeeded.');
    }
}
