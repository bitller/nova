<?php

namespace App\Listeners;

use App\Events\FailedLogIn;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogLoginAttempt
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
     * @param  FailedLogIn  $event
     * @return void
     */
    public function handle(FailedLogIn $event)
    {
        //
    }
}
