<?php

namespace App\Http\Requests\Bill;

use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authorize and validate CreateBillRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateBillRequest extends AjaxRequest {

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
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
            'campaign_number' => ['required_unless:use_current_campaign,true', 'exists:campaigns,number'],
            'campaign_year' => ['required_unless:use_current_campaign,true', 'exists:campaigns,year'],
            'use_current_campaign' => ['bool'],
            'client' => ['required', 'string', 'min:3', 'max:60'],
        ];
    }
}