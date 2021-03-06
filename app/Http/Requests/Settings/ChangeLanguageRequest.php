<?php

namespace App\Http\Requests\Settings;

use App\Helpers\PermissionsHelper;
use App\Http\Requests\AjaxRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Validate and authorize ChangeLanguageRequest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ChangeLanguageRequest extends AjaxRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth) {
        if ($auth->check() && PermissionsHelper::changeLanguage()) {
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
            'language' => ['required', 'exists:languages,key']
        ];
    }

}