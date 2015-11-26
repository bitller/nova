<?php

namespace App\Http\Requests\HelpCenter;

use App\Helpers\AjaxResponse;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\Validator;

/**
 * Authorize and validate AskQuestionRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AskQuestionRequest extends AjaxRequest {

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
            'question_category_id' => ['required', 'exists:question_categories,id'],
            'question_content' => ['required', 'string', 'between:20,5000'],
            'question_title' => ['required', 'string', 'between:5,55'],
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
        $fields = ['question_category_id', 'question_content', 'question_title'];
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