<?php

namespace App\Listeners;

use App\Events\FailedLogIn;
use App\Helpers\LogTypes;
use App\LoginAttempt;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Listener for login attempts
 * @package App\Listeners
 */
class LogLoginAttempt {

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
     * @param  FailedLogIn  $event
     * @return void
     */
    public function handle(FailedLogIn $event){

        $logTypes = new LogTypes();

        $loginAttempt = new LoginAttempt();
        $loginAttempt->user_id = $event->userId;
        $loginAttempt->ip = 'ip goes here';
        $loginAttempt->client = 'client goes here';
        $loginAttempt->save();

    }
}
