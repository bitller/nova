<?php

namespace App\Http\Requests;

use App\Helpers\AjaxResponse;
use Illuminate\Contracts\Validation\Validator;

/**
 * Return ajax response with formed errors.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AjaxRequestWithFormedErrors extends Request {

    /**
     * Fields to be validated.
     *
     * @var array
     */
    public $fields = [];

    /**
     * Error message used.
     *
     * @var string
     */
    public $failMessage = 'error';
    
    /**
     * @param array $errors
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors) {

        $response = new AjaxResponse();

        $response->setFailMessage($this->failMessage);
        $response->addExtraFields(['errors' => $errors]);
        return response($response->get(), $response->badRequest());
    }

    /**
     * @param Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator) {

        $messages = $validator->errors();
        $errors = [];

        foreach ($this->fields as $field) {
            if (!$messages->has($field)) {
                continue;
            }
            $errors[$field] = $messages->first($field);
        }

        return $errors;

    }
}