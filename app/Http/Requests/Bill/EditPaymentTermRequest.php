<?php

namespace App\Http\Requests\Bill;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Validate and authorize EditPaymentTermRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditPaymentTermRequest extends AjaxRequest {

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
            'payment_term' => ['required', 'date_format:d-m-Y']
        ];
    }

}