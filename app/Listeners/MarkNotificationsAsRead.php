<?php

namespace App\Listeners;

use App\Events\NotificationsWereRead;
use App\UserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * MarkNotificationsAsRead event listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MarkNotificationsAsRead {

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
     * @param  NotificationsWereRead  $event
     * @return void
     */
    public function handle(NotificationsWereRead $event) {
        UserNotification::where('user_id', \Auth::user()->id)->whereIn('notification_id', $event->notificationsIds)->update([
            'read' => 1
        ]);
    }
}
