<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * NotificationsWereRead event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NotificationsWereRead extends Event {

    use SerializesModels;

    /**
     * @var array
     */
    public $notificationsIds = [];

    /**
     * Create a new event instance.
     *
     * @param $notifications
     */
    public function __construct($notifications) {
        foreach ($notifications as $notification) {
            $this->notificationsIds[] = $notification->id;
        }
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn() {
        return [];
    }
}
