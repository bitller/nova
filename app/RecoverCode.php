<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * RecoverCode model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RecoverCode extends Model {

    /**
     * Return only valid codes. After certain time, a code become invalid.
     *
     * @param $query
     * @return mixed
     */
    public function scopeValid($query) {
        return $query->where('created_at', '>=', date('Y-m-d H:i:s', time()-60*60));
    }

}
