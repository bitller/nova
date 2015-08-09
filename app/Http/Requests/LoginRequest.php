<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;

/**
 * Check if user is allowed to make requests to login page
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LoginRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     * @param Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth) {
        return !$auth->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }
}
