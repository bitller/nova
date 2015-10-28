<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * BillApplicationProduct model
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillApplicationProduct extends Model {

    /**
     * @param $query
     * @param $productId
     */
    public function scopeSoldPieces($query, $productId) {
        $query->where('product_id', $productId);
    }

    /**
     * @param $query
     * @param $productId
     */
    public function scopeTotalPrice($query, $productId) {
        $query->where('product_id', $productId);
    }
}
