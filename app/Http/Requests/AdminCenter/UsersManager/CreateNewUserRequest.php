<?php

namespace App\Http\Requests\AdminCenter\UsersManager;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate CreateNewUserRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateNewUserRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['new_user_email', 'new_user_password', 'new_user_password_confirmation', 'make_special_user', 'user_password'];

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

    public function rules() {
        return [
            'user_password' => ['required', 'check_auth_user_password'],
            'make_special_user' => ['boolean'],
            'new_user_password_confirmation' => ['required'],
            'new_user_password' => ['required', 'confirmed'],
            'new_user_email' => ['required', 'email', 'not_exists:users,email']
        ];
    }

}