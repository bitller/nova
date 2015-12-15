<?php

namespace App\Http\Requests\AdminCenter\UsersManager\User\Bills;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate MakeAllUserBillsUnpaidRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MakeAllUserBillsUnpaidRequest extends AjaxRequest {

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
        return [];
    }

}