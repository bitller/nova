<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * UserLoggedIn event
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserLoggedIn extends Event {

    /**
     * @var int|null
     */
    public $userId = null;

    /**
     * Create a new event instance.
     * @param int $userId
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
