<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

/**
 * Implements formatErrors() for ajax requests
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AjaxRequest extends Request {

    /**
     * @param array $errors
     * @return mixed
     */
    public function response(array $errors) {

        $error = '';

        foreach ($errors as $errorMessage) {
            $error = $errorMessage;
        }

        $response = [
            'success' => false,
            'title' => trans('common.fail'),
            'message' => $error
        ];

        return response($response, 422)->header('Content-Type', 'application/json');
    }

    /**
     * @return mixed
     */
    public function forbiddenResponse() {
        return response(['success' => false])->header('Content-Type', 'application/json');
    }

    /**
     * Format error messages for ajax requests
     *
     * @param Validator $validator
     * @return array
     * @internal param Request $request
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
