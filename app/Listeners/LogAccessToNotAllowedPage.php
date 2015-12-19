<?php

namespace App\Listeners;

use App\Events\UserAccessedNotAllowedPage;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class LogAccessToNotAllowedPage listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogAccessToNotAllowedPage {

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
     * @param  UserAccessedNotAllowedPage  $event
     * @return void
     */
    public function handle(UserAccessedNotAllowedPage $event) {
        UserActions::notAllowed($event->userId, 'Tried to access ' . $event->page . ' page.');
    }
}
