<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model {

    public function scopePublic($query) {
        return $query->select('displayed_bills', 'displayed_clients', 'displayed_products', 'displayed_custom_products', 'language');
    }

}
