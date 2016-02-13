<?php

namespace App\Http\Requests\Statistics;

use App\Http\Requests\AjaxRequest;
use Illuminate\Auth\Guard;

/**
 * Authorize and validate GetCampaignNumbersRequest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class GetCampaignNumbersRequest extends AjaxRequest {

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
            'year' => ['required', 'exists:campaigns,year']
        ];
    }

}