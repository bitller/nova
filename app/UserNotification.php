<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * UserNotification model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserNotification extends Model {
    
    /**
     * Attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Return user of this notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne('App/User');
    }

    /**
     * Return notification of this user notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notification() {
        return $this->hasOne('App/Notification');
    }

    /**
     * Return only read notifications.
     *
     * @return mixed
     */
    public function scopeRead() {
        return $this->where('read', true);
    }

    /**
     * Return only unread notifications.
     *
     * @return mixed
     */
    public function scopeUnread() {
        return $this->where('read', false);
    }
}