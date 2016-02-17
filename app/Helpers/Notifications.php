<?php

namespace App\Helpers;
use App\User;

/**
 * Handle work with notifications.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Notifications {

    /**
     * Return unread notifications.
     *
     * @param int $userId
     * @return array
     */
    public static function getUnread($userId) {
        $notifications = User::find($userId)
            ->notifications()
            ->where('read', 0)
            ->leftJoin('notifications', 'user_notifications.notification_id', '=', 'notifications.id')
            ->get();

        return [
            'notifications' => $notifications,
            'number_of_notifications' => count($notifications)
        ];
    }

}