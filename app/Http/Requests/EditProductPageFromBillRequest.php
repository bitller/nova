<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate EditProductPageFromBillRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditProductPageFromBillRequest extends AjaxRequest {

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
            'product_id' => ['required', 'numeric'],
            'bill_product_id' => ['required', 'numeric'],
            'product_code' => ['required', 'digits:5'],
            'product_page' => ['required', 'numeric', 'between:1,2000']
        ];
    }
}
