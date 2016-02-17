<?php

namespace App\Http\Controllers;
use App\Events\NotificationsWereRead;
use App\Helpers\AjaxResponse;
use App\Helpers\Notifications;
use App\User;
use App\UserNotification;
use Illuminate\Support\Facades\Auth;

/**
 * Allow user to see notifications.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NotificationsController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * @return mixed
     */
    public function getUnreadNotifications() {

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));

        $notificationDetails = Notifications::getUnread(\Auth::user()->id);

        $response->addExtraFields($notificationDetails);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Mark notifications as read.
     */
    public function markNotificationsAsRead() {

        $notificationDetails = Notifications::getUnread(\Auth::user()->id);

        // Make current notifications as read
        event(new NotificationsWereRead($notificationDetails['notifications']));
    }
}