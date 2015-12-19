<?php

namespace App\Listeners;

use App\Events\UserCreatedNewBill;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogCreationOfNewBill listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogCreationOfNewBill {

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
     * @param  UserCreatedNewBill  $event
     * @return void
     */
    public function handle(UserCreatedNewBill $event) {
        UserActions::allowed($event->userId, 'Created new bill with id ' . $event->billId);
    }
}
