<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * HomepageAccessed event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class HomepageAccessed extends Event {

    use SerializesModels;

    /**
     * @var null
     */
    public $userId = null;

    /**
     * Create a new event instance.
     * @param $userId
     */
    public function __construct($userId) {
        $this->userId = $userId;
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
