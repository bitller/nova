<?php

namespace App\Listeners;

use App\Events\UserDeletedBill;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogBillDeletion listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogBillDeletion {

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
     * @param  UserDeletedBill  $event
     * @return void
     */
    public function handle(UserDeletedBill $event) {
        UserActions::allowed($event->userId, 'Deleted bill with id ' . $event->billId . '.');
    }
}
