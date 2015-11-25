<?php

namespace App\Http\Requests\HelpCenter;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

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
            'question_title' => ['required', 'string', 'between:5,55'],
            'question_content' => ['required', 'string', 'between:20,5000']
        ];
    }

}