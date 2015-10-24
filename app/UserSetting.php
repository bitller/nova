<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * UserSetting model
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserSetting extends Model {

    /**
     * Return fields  allowed to be displayed public.
     *
     * @param $query
     * @return mixed
     */
    public function scopePublic($query) {
        return $query->select('displayed_bills', 'displayed_clients', 'displayed_products', 'displayed_custom_products', 'language');
    }

}
