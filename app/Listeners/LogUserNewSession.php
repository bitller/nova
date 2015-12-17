<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogUserNewSession listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogUserNewSession {

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
     * @param  UserLoggedIn  $event
     * @return void
     */
    public function handle(UserLoggedIn $event) {
        UserActions::allowed('Logged in.');
    }
}
