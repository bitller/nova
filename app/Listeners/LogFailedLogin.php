<?php

namespace App\Listeners;

use App\Events\FailedLogIn;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogFailedLogin listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogFailedLogin {

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
    public function handle(FailedLogIn $event) {
        UserActions::wrongFormat($event->userId, 'Failed login attempt.');
        // todo Save login attempts also in another place to implement brute force protection
    }
}
