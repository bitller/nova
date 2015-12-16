<?php

namespace App\Http\Requests\AdminCenter\UsersManager\User\CustomProducts;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate DeleteUserCustomProductsRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteUserCustomProductsRequest extends AjaxRequest {

    /**
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
     * @return array
     */
    public function rules() {
        return [];
    }

}