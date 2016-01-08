<?php

namespace App\Http\Requests\AdminCenter\Subscriptions\Offers;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate UseOfferOnSignUpRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UseOfferOnSignUpRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['user_password'];

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
            'user_password' => ['required', 'check_auth_user_password']
        ];
    }

}