<?php

namespace App\Http\Requests\AdminCenter\ProductsManager;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate CheckIfProductCodeIsUsedRequest.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CheckIfProductCodeIsUsedRequest extends AjaxRequestWithFormedErrors {
       
    /**
     * @var array
     */
    public $fields = ['product_code'];

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
        return [
            'product_code' => ['required', 'digits:5']
        ];
    }
}