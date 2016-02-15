<?php

namespace App\Http\Requests\MyProducts;

use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate AddCustomProductRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AddCustomProductRequest extends AjaxRequestWithFormedErrors {

    public $fields = ['name', 'code'];

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
            'name' => ['required', 'string', 'between:3,50'],
            'code' => ['required', 'digits:5', 'not_exists:application_products,code']
        ];
    }

}