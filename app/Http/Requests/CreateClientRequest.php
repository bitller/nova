<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\Validator;

/**
 * Authorize and validate CreateClientRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateClientRequest extends Request {

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
            'name' => ['required', 'min:3', 'max:60'],
            'phone' => ['between:9,12', 'numeric']
        ];
    }

    /**
     * @param Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator) {

        $errors = $validator->errors()->all();
        $error = '';

        foreach ($errors as $errorMessage) {
            $error = $errorMessage;
        }

        return [
            'success' => false,
            'title' => trans('common.fail'),
            'message' => $error
        ];
    }
}
