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
        return $query->select(
            'user_settings.displayed_bills',
            'user_settings.displayed_clients',
            'user_settings.displayed_products',
            'user_settings.displayed_custom_products',
            'languages.language'
        )->join('languages', 'languages.id', '=', 'user_settings.language_id');
    }

}
