<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Language model
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Language extends Model {

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublic($query) {
        return $query->select('key', 'language');
    }

}
