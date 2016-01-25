<?php

namespace App\Http\Requests\Clients;

use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate EditClientPhoneNumberRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditClientPhoneNumberRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['client_phone_number'];

    /**
     * @param Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth) {
        return $auth->check();
    }

    /**
     * @return array
     */
    public function rules() {
        return [
            'client_phone_number' => ['digits:10', 'phone_number_not_used_by_another_user_client']
        ];
    }
}