<?php

namespace App\Helpers;

use App\RecoverCode;
use Illuminate\Support\Facades\Auth;

/**
 * Generate different things for the app.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Generator {

    /**
     * Generate and save recover code for current user.
     *
     * @param int $userId
     * @param int $length
     * @return string
     */
    public static function recoverCode($userId, $length = 200) {

        // Delete old codes
        RecoverCode::where('user_id', $userId)->delete();

        // Generate new one
        $code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length) . $userId;

        // Insert in database
        $recoverCode = new RecoverCode();
        $recoverCode->user_id = $userId;
        $recoverCode->code = $code;
        $recoverCode->save();

        return $code;
    }

}