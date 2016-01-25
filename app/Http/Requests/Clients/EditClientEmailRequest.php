<?php

namespace App\Http\Requests\Clients;

use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate EditClientEmailRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditClientEmailRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['client_email'];

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
            'client_email' => ['email', 'email_not_used_by_another_user_client']
        ];
    }
}