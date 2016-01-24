<?php

namespace App\Http\Requests\Clients;

use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate CreateClientRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateClientRequest extends AjaxRequestWithFormedErrors {

    public $fields = ['client_name', 'client_email', 'client_phone_number'];

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
            'client_phone_number' => ['digits:10', 'phone_number_not_used_by_another_user_client'],
            'client_email' => ['email', 'email_not_used_by_another_user_client'],
            'client_name' => ['required', 'string', 'between:3,60']
        ];
    }

}