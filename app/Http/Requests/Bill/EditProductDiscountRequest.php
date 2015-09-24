<?php

namespace App\Http\Requests\Bill;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate EditProductDiscountRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditProductDiscountRequest extends AjaxRequest {

    /**
     * Authorize and validate EditProductQuantityRequest.
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
            'product_id' => ['required', 'numeric'],
            'product_code' => ['required', 'digits:5'],
            'product_discount' => ['required', 'numeric', 'between:0,100']
        ];
    }

}