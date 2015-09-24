<?php

namespace App\Http\Requests\Bill;

use App\Http\Requests\AjaxRequest;
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
            'page' => ['numeric', 'between:1,2000'],
            'code' => ['required', 'digits:5'],
            'price' => ['required', 'numeric', 'between:0,9999'],
            'quantity' => ['numeric', 'between:1,999'],
            'discount' => ['numeric', 'between:1,100']
        ];
    }

}