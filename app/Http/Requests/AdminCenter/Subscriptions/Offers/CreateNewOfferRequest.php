<?php

namespace App\Http\Requests\AdminCenter\Subscriptions\Offers;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequest;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate CreateNewOfferRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateNewOfferRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['offer_name', 'offer_amount', 'promo_code', 'user_password'];

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
            'user_password' => ['required', 'check_auth_user_password'],
            'promo_code' => ['string', 'between:1,25'],
            'offer_amount' => ['required', 'numeric', 'min:2'],
            'offer_name' => ['required', 'between:3,20'],
        ];
    }
}