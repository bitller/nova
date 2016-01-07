<?php

namespace App\Http\Requests\AdminCenter\Subscriptions\Offers;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate EditOfferNameRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditOfferNameRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['offer_name', 'user_password'];

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
            'offer_name' => ['required', 'string', 'between:3,25'],
            'user_password' => ['required', 'check_auth_user_password']
        ];
    }

}