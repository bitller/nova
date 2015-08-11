<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Helpers\LogTypes;
use App\UserLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Listen when a user logs in
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SaveUserAccess {
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
     * @param  UserLoggedIn $event
     * @internal param Guard $auth
     */
    public function handle(UserLoggedIn $event) {

        $logTypes = new LogTypes();

        $userLog = new UserLog();
        $userLog->message = 'Logged in';
        $userLog->log_type_id = $logTypes->getInfoId();
        $userLog->user_id = $event->userId;
        $userLog->save();

    }
}
