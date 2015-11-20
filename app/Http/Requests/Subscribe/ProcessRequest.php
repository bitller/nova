<?php

namespace App\Http\Requests\Subscribe;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate ProcessRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProcessRequest extends AjaxRequest {

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
            'token' => ['required', 'between:10, 50']
        ];
    }

}