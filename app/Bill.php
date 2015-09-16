<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Bill model
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Bill extends Model {

    public function products() {
        return $this->hasMany('App\BillProduct');
    }

    public function applicationProducts() {
        return $this->hasMany('App\BillApplicationProduct');
    }

}
