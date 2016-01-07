<?php

namespace App\Http\Requests\AdminCenter\Subscriptions\Offers;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate EditOfferAmountRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditOfferAmountRequest extends AjaxRequestWithFormedErrors {

    /**
     * Fields to be validated with individual error.
     *
     * @var array
     */
    public $fields = ['offer_amount', 'user_password'];

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
            'offer_amount' => ['required', 'numeric', 'between:2,99999'],
            'user_password' => ['required', 'check_auth_user_password'],
        ];
    }

}