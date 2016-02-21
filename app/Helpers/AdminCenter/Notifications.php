<?php

namespace App\Helpers\AdminCenter;

use App\Events\NotificationCreated;
use App\Events\NotificationTargetsSet;
use App\Helpers\AjaxResponse;
use App\Notification;
use App\TargetedUser;
use App\User;

/**
 * Allow admin to work with notifications.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Notifications {

    /**
     * Target groups.
     *
     * @var array
     */
    private static $targetGroups = [
        'all' => 'all',
        'none' => 'None'
    ];

    /**
     * Get notifications.
     *
     * @param bool|int $limit
     * @return mixed
     */
    public static function get($limit = false) {

        $notifications = Notification::select(
                'notifications.id', 'notification_types.type', 'notifications.title', 'notifications.message', 'notifications.created_at',
                'notifications.updated_at', 'targeted_users.key', 'targeted_users.name as target_group'
            )->leftJoin('notification_types', 'notifications.notification_type_id', '=', 'notification_types.id')
            ->leftJoin('targeted_users', 'notifications.targeted_user_id', '=', 'targeted_users.id')
            ->groupBy('notifications.id')
            ->orderBy('notifications.created_at', 'desc');

        if ($limit) {
            $notifications->limit($limit);
        }

        return $notifications->get();
    }

    /**
     * Handle given targeted group.
     *
     * @param string $targetedGroup
     * @param int $notificationId
     * @return mixed
     */
    public static function handle($targetedGroup, $notificationId) {

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('notifications.targeted_users_set'));

        // Handle case when all users are targeted
        if ($targetedGroup === self::$targetGroups['all']) {
            self::_handleAll($notificationId);
            return response($response->get())->header('Content-Type', 'application/json');
        }

        // Handle case when no user is targeted
        if ($targetedGroup === self::$targetGroups['none']) {
            self::_handleNone($notificationId);
            return response($response->get())->header('Content-Type', 'application/json');
        }

        $response->setFailMessage(trans('common.general_error'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Handle case when all users are targeted.
     *
     * @param int $notificationId
     */
    private static function _handleAll($notificationId) {

        self::_updateTargetGroup(self::$targetGroups['all'], $notificationId);

        $userIds = self::_buildUserIdsArray(User::all());

        $userNotifications = self::_buildUserNotificationsInsertData($userIds, $notificationId);
        \DB::table('user_notifications')->insert($userNotifications);

//        foreach ($userIds as $userId) {
            event(new NotificationCreated(Notification::where('id', $notificationId)->first()->title));
//        }
    }

    /**
     * Handle case when no user is targeted.
     *
     * @param int $notificationId
     */
    private static function _handleNone($notificationId) {
        self::_updateTargetGroup(self::$targetGroups['none'], $notificationId);
    }

    /**
     * Update targeted users group for given $notificationId.
     *
     * @param string $group
     * @param int $notificationId
     */
    private static function _updateTargetGroup($group, $notificationId) {

        Notification::where('id', $notificationId)
            ->update([
                'targeted_user_id' => TargetedUser::where('name', $group)->first()->id
            ]);
    }

    /**
     * Return array with user ids.
     *
     * @param Object $usersQuery
     * @return array
     */
    private static function _buildUserIdsArray($usersQuery) {

        $userIds = [];

        foreach ($usersQuery as $user) {
            $userIds[] = $user->id;
        }

        return $userIds;
    }

    /**
     * Return array with insert data for user_notifications table.
     *
     * @param array $userIds
     * @param int $notificationId
     * @return array
     */
    private static function _buildUserNotificationsInsertData($userIds, $notificationId) {

        $userNotifications = [];

        foreach ($userIds as $userId) {
            $userNotifications[] = [
                'user_id' => $userId,
                'notification_id' => $notificationId
            ];
        }

        return $userNotifications;
    }
}