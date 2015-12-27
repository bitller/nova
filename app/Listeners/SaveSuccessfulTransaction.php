<?php

namespace App\Listeners;

use App\Events\SubscriptionSucceeded;
use App\Subscription;
use App\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * SaveSuccessfulTransaction listener.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SaveSuccessfulTransaction {

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
     * @param  SubscriptionSucceeded  $event
     * @return void
     */
    public function handle(SubscriptionSucceeded $event) {

        // Get subscription id
        $query = Subscription::where('paymill_subscription_id', $event->subscription['id'])->first();

        $transaction = new Transaction();
        $transaction->paymill_transaction_id = $event->transaction['id'];
        $transaction->user_id = $event->userId;
        $transaction->subscription_id = $query->id;
        $transaction->amount = $event->transaction['amount'];
        $transaction->status = $event->transaction['status'];
        $transaction->response_code = $event->transaction['response_code'];
        $transaction->save();
    }
}
