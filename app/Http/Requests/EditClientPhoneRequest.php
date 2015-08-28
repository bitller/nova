<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;

/**
 * Validate and authorize EditClientPhoneRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditClientPhoneRequest extends AjaxRequest {

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
            'phone' => ['required', 'digits_between:9,12']
        ];
    }
}
