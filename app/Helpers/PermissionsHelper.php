<?php

namespace App\Helpers;

use App\SecuritySetting;

/**
 * Handle work with permissions.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PermissionsHelper {

    /**
     * Return true if new users are allowed, false otherwise.
     *
     * @return bool
     */
    public static function newUsers() {
        $securitySetting = SecuritySetting::first();
        if ($securitySetting->allow_new_accounts) {
            return true;
        }
        return false;
    }

    /**
     * Return true if users are allowed to change application language, false otherwise.
     *
     * @return bool
     */
    public static function changeLanguage() {
        $securitySetting = SecuritySetting::first();
        if ($securitySetting->allow_users_to_change_language) {
            return true;
        }
        return false;
    }

}