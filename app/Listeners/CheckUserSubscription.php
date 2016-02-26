<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Helpers\UserHelper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckUserSubscription
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLoggedIn  $event
     * @return void
     */
    public function handle(UserLoggedIn $event) {
        UserHelper::updateSubscriptionIfExpired();
    }
}
