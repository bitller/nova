<?php

namespace App\Http\Requests\AdminCenter\ProductsManager;

use App\Helpers\Roles;
use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate AddNewApplicationProductRequest.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AddNewApplicationProductRequest extends AjaxRequestWithFormedErrors {
       
    /**
     * @var array
     */
    public $fields = ['product_code', 'product_name'];

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
            'product_code' => ['required', 'digits:5'],
            'product_name' => ['required', 'string', 'between:3,50']
        ];
    }
}