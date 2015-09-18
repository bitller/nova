<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Bill model
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Bill extends Model {

    /**
     * Relation to BillProduct model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany('App\BillProduct');
    }

    /**
     * Relation to BillApplicationProduct model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicationProducts() {
        return $this->hasMany('App\BillApplicationProduct');
    }

}
