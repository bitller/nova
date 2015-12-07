<?php

namespace App\Http\Requests\Auth;

use App\Helpers\AjaxResponse;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\Validator;

/**
 * Authorize and validate CreateAccountRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateAccountRequest extends AjaxRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
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
            'card_expiry_year' => ['required', 'numeric', 'between:16,30'],
            'card_expiry_month' => ['required', 'numeric', 'between:1,12'],
            'card_cvv_code' => ['required', 'numeric', 'length:3'],
            'card_number' => ['required', 'numeric', 'between:13,19'],
            'password_confirmation' => ['required', 'min:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'email' => ['required', 'email', 'unique:users,email'],
        ];
    }

    /**
     * @param array $errors
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors) {

        $response = new AjaxResponse();
        $response->setFailMessage('error');
        $response->addExtraFields(['errors' => $errors]);
        return response($response->get(), $response->badRequest());

    }

    /**
     * @param Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator) {

        $messages = $validator->errors();
        $fields = ['email', 'password', 'password_confirmation', 'card_number', 'card_cvv_code', 'card_expiry_month', 'card_expiry_year'];
        $errors = [];

        foreach ($fields as $field) {
            if (!$messages->has($field)) {
                continue;
            }
            $errors[$field] = $messages->first($field);
        }

        return $errors;

    }

}