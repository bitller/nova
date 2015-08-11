<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * FailedLogIn event
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class FailedLogIn extends Event {

    use SerializesModels;

    /**
     * @var int
     */
    protected $userId;

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
