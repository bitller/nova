<?php

namespace App\Listeners;

use App\Events\HomepageAccessed;
use App\Helpers\UserActions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * LogGetBillsRequest listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LogGetBillsRequest {

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
     * @param  HomepageAccessed  $event
     * @return void
     */
    public function handle(HomepageAccessed $event) {
        UserActions::allowed($event->userId, 'Requested ajax pagination of their bills.');
    }
}
