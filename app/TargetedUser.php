<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * TargetedUser model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class TargetedUser extends Model {
    
    /**
     * Attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}