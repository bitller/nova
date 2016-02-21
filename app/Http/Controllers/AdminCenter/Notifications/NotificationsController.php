<?php

namespace App\Http\Controllers\AdminCenter\Notifications;

use App\Helpers\AdminCenter\Notifications;
use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\NotificationsManager\SetTargetedUsersRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\CreateNotificationRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\DeleteAllNotificationsRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\DeleteNotificationRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\EditNotificationMessageRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\EditNotificationTitleRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\GetAllNotificationsRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\GetLastNotificationsRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\GetNotificationTypesRequest;
use App\Http\Requests\AdminCenter\NotificationsManager\GetTargetedUsersRequest;
use App\Notification;
use App\NotificationType;
use App\TargetedUser;
use App\User;
use App\UserNotification;

/**
 * Notifications controller.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NotificationsController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        return view('admin-center.notifications.index');
    }

    /**
     * Return last notifications.
     *
     * @param GetLastNotificationsRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function getLast(GetLastNotificationsRequest $request, AjaxResponse $response) {

        $response->setSuccessMessage(trans('notifications.last_notifications_returned'));

        $notifications = Notifications::get(10);

        $response->addExtraFields([
            'notifications' => $notifications,
            'number_of_notifications' => count($notifications)
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Return all notifications.
     *
     * @param GetAllNotificationsRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function getAll(GetAllNotificationsRequest $request, AjaxResponse $response) {

        $response->setSuccessMessage(trans('notifications.all_notifications_returned'));

        $notifications = Notifications::get();

        $response->addExtraFields([
            'notifications' => $notifications,
            'number_of_notifications' => count($notifications)
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Create new notification.
     *
     * @param CreateNotificationRequest $request
     * @return mixed
     */
    public function create(CreateNotificationRequest $request) {

        Notification::create([
            'title' => $request->get('title'),
            'message' => $request->get('message'),
            'notification_type_id' => NotificationType::where('type', $request->get('type'))->first()->id
        ]);

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('notifications.notification_created'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Return notification types.
     *
     * @param GetNotificationTypesRequest $request
     * @return mixed
     */
    public function types(GetNotificationTypesRequest $request) {

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('notifications.notification_types_returned'));
        $response->addExtraFields([
            'notification_types' => NotificationType::all()
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete notification.
     *
     * @param DeleteNotificationRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function delete(DeleteNotificationRequest $request, AjaxResponse $response) {

        Notification::destroy($request->get('notification_id'));

        $response->setSuccessMessage(trans('notifications.notification_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit notification title.
     *
     * @param EditNotificationTitleRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function editTitle(EditNotificationTitleRequest $request, AjaxResponse $response) {

        Notification::where('id', $request->get('notification_id'))
            ->update([
                'title' => $request->get('notification_title')
            ]);

        $response->setSuccessMessage(trans('notifications.notification_title_updated'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit notification message.
     *
     * @param EditNotificationMessageRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function editMessage(EditNotificationMessageRequest $request, AjaxResponse $response) {

        Notification::where('id', $request->get('notification_id'))
            ->update([
                'message' => $request->get('notification_message')
            ]);

        $response->setSuccessMessage(trans('notifications.notification_message_updated'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete all notifications.
     *
     * @param DeleteAllNotificationsRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function deleteAll(DeleteAllNotificationsRequest $request, AjaxResponse $response) {

        \DB::table('notifications')->delete();

        $response->setSuccessMessage(trans('notifications.all_notifications_deleted'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Return targeted users.
     *
     * @param GetTargetedUsersRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function getTargetedUsers(GetTargetedUsersRequest $request, AjaxResponse $response) {

        $targetedUsers = TargetedUser::all();

        $response->setSuccessMessage(trans('notifications.targeted_users_returned'));
        $response->addExtraFields([
            'targeted_users' => $targetedUsers,
            'number_of_targeted_users' => count($targetedUsers)
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Set targeted users.
     *
     * @param SetTargetedUsersRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function setTargetedUsers(SetTargetedUsersRequest $request, AjaxResponse $response) {

        $response->setSuccessMessage(trans('notifications.targeted_users_set'));
        $notificationId = $request->get('notification_id');
        $targetGroup = $request->get('target_group');

        Notification::where('id', $notificationId)->update([
            'targeted_user_id' => TargetedUser::where('name', $targetGroup)->first()->id
        ]);

        if ($targetGroup === 'None') {
            return response($response->get())->header('Content-Type', 'application/json');
        }

        // Notify all users
        if ($targetGroup === 'all') {

            $usersIds = [];
            $usersQuery = User::all();

            // Build an array with all users ids
            foreach ($usersQuery as $user) {
                $usersIds[] = $user->id;
            }

            // Build array with insert data
            $usersNotifications = [];

            foreach ($usersIds as $userId) {
                $usersNotifications[] = [
                    'user_id' => $userId,
                    'notification_id' => $notificationId
                ];
            }

            \DB::table('user_notifications')->insert($usersNotifications);

            return response($response->get())->header('Content-Type', 'application/json');
        }

        $response->setFailMessage(trans('common.general_error'));

        return response($response->get())->header('Content-Type', 'application/json');
    }
}