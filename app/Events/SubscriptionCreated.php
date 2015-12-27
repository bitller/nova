<?php

namespace App\Events;

use App\Events\Event;
use App\Subscription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * SubscriptionCreated event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionCreated extends Event {

    use SerializesModels;

    /**
     * @var null
     */
    public $subscription = null;

    /**
     * @var null
     */
    public $userId = null;

    /**
     * Create a new event instance.
     *
     * @param $subscription
     */
    public function __construct($subscription) {
        $this->subscription = $subscription;
        // Get user id
        $query = Subscription::where('paymill_subscription_id', $subscription['id'])->first();
        $this->userId = $query->user_id;
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
