<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Notification model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Notification extends Model {
    
    /**
     * Attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];    
}