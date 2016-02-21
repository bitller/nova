<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUser
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
     * @param  NotificationCreated  $event
     * @return void
     */
    public function handle(NotificationCreated $event) {
        //
    }
}
