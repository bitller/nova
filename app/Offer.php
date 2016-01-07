<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Offer model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Offer extends Model {

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCountAssociatedSubscriptions($query) {
        return $query->leftJoin('subscriptions', 'offers.id', '=', 'subscriptions.offer_id')
            ->selectRaw('offers.*, count(subscriptions.id) as associated_subscriptions')
            ->groupBy('offers.id');
    }

}
