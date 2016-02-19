<?php

namespace App\Http\Requests\AdminCenter\NotificationsManager;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate CreateNotificationRequest.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateNotificationRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['type', 'title', 'message'];

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
            'message' => ['required', 'string', 'between:3,3000'],
            'title' => ['required', 'string', 'between:3,30'],
            'type' => ['required', 'exists:notification_types,type']
        ];
    }
}