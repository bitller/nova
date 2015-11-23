<?php

namespace App\Http\Requests\AdminCenter\HelpCenterManager;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate AddCategoryRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AddCategoryRequest extends AjaxRequest {

    /**
     * Determine if the user is authorized to make this request.
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
            'category_name' => ['required', 'string', 'between:3,50']
        ];
    }

}