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
