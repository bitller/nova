<?php

namespace App\Listeners;

use App\Events\SubscriptionFailed;
use App\Subscription;
use App\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * SaveFailedTransaction listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SaveFailedTransaction {

    /**
     * Create the event listener.
     *
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SubscriptionFailed  $event
     * @return void
     */
    public function handle(SubscriptionFailed $event) {

        // Stop event propagation if subscription does not exists
        if (!$event->userId) {
            return false;
        }

        // Get subscription id
        $subscriptionQuery = Subscription::where('paymill_subscription_id', $event->subscription['id'])->first();

        $transaction = new Transaction();
        $transaction->paymill_transaction_id = $event->transaction['id'];
        $transaction->subscription_id = $subscriptionQuery->id;
        $transaction->user_id = $event->userId;
        $transaction->amount = $event->transaction['amount'];
        $transaction->status = $event->transaction['status'];
        $transaction->response_code = $event->transaction['response_code'];
        $transaction->save();
    }
}
