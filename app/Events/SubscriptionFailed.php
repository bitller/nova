<?php

namespace App\Events;

use App\Events\Event;
use App\Subscription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * SubscriptionFailed event.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubscriptionFailed extends Event {

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
        $query = Subscription::where('paymill_susbcription_id', $subscription['id'])->first();
        if ($query->user_id) {
            $this->userId = null;
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
