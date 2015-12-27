<?php

namespace App\Events;

use App\Events\Event;
use App\Subscription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * SubscriptionSucceeded event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionSucceeded extends Event {

    use SerializesModels;

    /**
     * @var null
     */
    public $subscription = null;

    /**
     * @var null
     */
    public $transaction = null;

    /**
     * @var null
     */
    public $userId = null;

    /**
     * Create a new event instance.
     *
     * @param $subscription
     * @param $transaction
     */
    public function __construct($subscription, $transaction) {

        $this->subscription = $subscription;
        $this->transaction = $transaction;

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
