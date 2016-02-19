<?php

namespace App\Http\Requests\AdminCenter\NotificationsManager;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate DeleteNotificationRequest.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteNotificationRequest extends AjaxRequest {

    /**
     * @param Guard $auth
     * @param Roles $roles
     * @return bool
     */
    public function authorize(Guard $auth, Roles $roles) {
        if ($auth->check() && $roles->isAdmin()) {
            return true;
        }

        return false;
    }
    
    /**
     * @return array
     */
    public function rules() {
        return [
            'notification_id' => ['required', 'exists:notifications,id']
        ];
    }
}