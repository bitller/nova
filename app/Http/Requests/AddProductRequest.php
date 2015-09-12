<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate AddProductRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AddProductRequest extends AjaxRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Guard $auth
     * @return bool
     * @internal param Guard $guard
     */
    public function authorize(Guard $auth) {
        return $auth->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'code' => ['required', 'digits:5'],
            'name' => ['required', 'between:3,50']
        ];
    }
}
