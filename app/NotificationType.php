<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * NotificationType model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NotificationType extends Model {
    
    /**
     * Attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Return all notifications with this type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications() {
        return $this->hasMany('App/Notification');
    }
}