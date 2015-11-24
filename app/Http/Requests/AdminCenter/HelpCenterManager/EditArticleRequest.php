<?php

namespace App\Http\Requests\AdminCenter\HelpCenterManager;

use App\Helpers\AjaxResponse;
use App\Helpers\Roles;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\Validator;

/**
 * Authorize and validate EditArticleRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditArticleRequest extends AjaxRequest {

    /**
     * Authorize and validate AddCategoryRequest.
     *
     * @param Guard $auth
     * @param Roles $roles
     * @return bool
     */
    public function authorize(Guard $auth, Roles $roles) {
        if ($auth->check() && $roles->isAdmin()) {
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
            'article_id' => ['required', 'numeric', 'exists:help_center_articles,id'],
            'article_title' => ['required', 'string', 'between:3,50'],
            'article_content' => ['required', 'string', 'between:20,5000']
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
        return response($response->get(), $response->badRequest())->header('Content-Type', 'application/json');

    }

    /**
     * @param Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator) {

        $messages = $validator->errors();
        $fields = ['article_id', 'article_title', 'article_content'];
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