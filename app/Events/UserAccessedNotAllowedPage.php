<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * UserAccessedNotAllowedPage event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserAccessedNotAllowedPage extends Event {

    use SerializesModels;

    /**
     * @var null
     */
    public $userId = null;

    /**
     * @var string
     */
    public $page = '';

    /**
     * Create a new event instance.
     *
     * @param $userId
     * @param $page
     */
    public function __construct($userId, $page) {
        $this->userId = $userId;
        $this->page = $page;
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
