<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * UserCreatedNewBill event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserCreatedNewBill extends Event {

    use SerializesModels;

    /**
     * @var null
     */
    public $userId = null;

    /**
     * @var null
     */
    public $billId = null;

    /**
     * Create a new event instance.
     *
     * @param int $userId
     * @param int $billId
     */
    public function __construct($userId, $billId) {
        $this->userId = $userId;
        $this->billId = $billId;
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
