<?php

namespace App\Listeners;

use App\Events\SubscriptionCreated;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogCreationOfNewSubscription listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogCreationOfNewSubscription {

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
     * @param  SubscriptionCreated  $event
     * @return void
     */
    public function handle(SubscriptionCreated $event) {
        UserActions::info($event->userId, 'Subscription with id ' . $event->subscription['id'] . ' was created.');
    }
}
