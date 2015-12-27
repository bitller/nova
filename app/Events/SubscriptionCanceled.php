<?php

namespace App\Events;

use App\Events\Event;
use App\Subscription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class SubscriptionCanceled event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionCanceled extends Event {

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
        $subscriptionQuery = Subscription::where('paymill_subscription_id', $subscription['id'])->first();
        if ($subscriptionQuery) {
            $this->userId = $subscriptionQuery->user_id;
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
