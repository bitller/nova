<?php

namespace App\Http\Requests\MyProducts;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate SearchProductsRequest.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SearchProductsRequest extends AjaxRequest {
       
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
            //
        ];
    }
}