<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillProduct extends Model {
    public function scopeSoldPieces($query, $productId) {
        $query->where('product_id', $productId);
    }

    public function scopeTotalPrice($query, $productId) {
        $query->where('product_id', $productId);
    }
}
