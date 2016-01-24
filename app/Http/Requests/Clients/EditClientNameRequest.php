<?php

namespace App\Http\Requests\Clients;

use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate EditClientNameRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditClientNameRequest extends AjaxRequestWithFormedErrors {

    /**
     * @var array
     */
    public $fields = ['client_name'];

    /**
     * @param Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth) {
        if ($auth->check()) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function rules() {
        return [
            'client_name' => ['required', 'string', 'between:3,60']
        ];
    }
}