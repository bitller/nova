<?php

namespace App\Http\Requests\Bill;

use App\Http\Requests\AjaxRequestWithFormedErrors;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate AddNotExistentProductRequest.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AddNotExistentProductRequest extends AjaxRequestWithFormedErrors {
       
    /**
     * @var array
     */
    public $fields = ['product_code', 'product_name'];
    
    /**
     * @param Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth) {
        return $auth->check();
    }
    
    /**
     * @return array
     */
    public function rules() {
        return [
            'product_name' => ['required', 'string', 'between:3,50'],
            'product_code' => ['required', 'not_exists:application_products,code', 'is_not_in_auth_user_products']
        ];
    }
}