<?php

namespace App\Http\Requests\Auth;

use App\Helpers\AjaxResponse;
use App\Helpers\PermissionsHelper;
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
        if (!$auth->check() && PermissionsHelper::newUsers()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'token' => ['required', 'min:9'],
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
        $fields = ['email', 'password', 'password_confirmation', 'token'];
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