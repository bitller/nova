<?php

namespace App\Http\Requests\HelpCenter;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate GetQuestionCategoriesRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class GetQuestionCategoriesRequest extends AjaxRequest {

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
        return [];
    }

}