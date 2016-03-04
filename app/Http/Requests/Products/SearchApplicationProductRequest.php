<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate SearchApplicationProductRequest.
 * 
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SearchApplicationProductRequest extends AjaxRequest {
       
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