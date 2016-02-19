<?php

namespace App\Helpers\AdminCenter;

use App\Notification;

/**
 * Allow admin to work with notifications.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Notifications {

    /**
     * Get notifications.
     *
     * @param bool|int $limit
     * @return mixed
     */
    public static function get($limit = false) {

        $notifications = Notification::select('notifications.id', 'notification_types.type', 'notifications.title', 'notifications.message', 'notifications.created_at', 'notifications.updated_at')
            ->leftJoin('notification_types', 'notifications.notification_type_id', '=', 'notification_types.id')
            ->groupBy('notifications.id')
            ->orderBy('notifications.created_at', 'desc');

        if ($limit) {
            $notifications->limit($limit);
        }

        return $notifications->get();
    }

}