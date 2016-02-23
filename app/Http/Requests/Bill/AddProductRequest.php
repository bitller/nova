<?php

namespace App\Http\Requests\Bill;

use App\Helpers\AjaxResponse;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\Validator;

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
            'product_quantity' => ['numeric', 'between:1,999'],
            'product_discount' => ['numeric', 'between:0,100'],
            'product_page' => ['numeric', 'between:1,2000'],
            'product_price' => ['required', 'numeric', 'between:0,9999'],
            'product_code' => ['required', 'digits:5'],
            'product_not_available' => ['required', 'bool']
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
        $fields = ['product_code', 'product_price', 'product_page', 'product_discount', 'product_quantity'];
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