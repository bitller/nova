<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Role model
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Role extends Model {

    /**
     * Indicate if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Database table used by the model
     *
     * @var string
     */
    protected $table = 'roles';

}
