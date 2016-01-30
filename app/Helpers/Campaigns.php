<?php

namespace App\Helpers;

use App\Campaign;

/**
 * Handle work with campaigns.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Campaigns {

    /**
     * Get current campaign
     *
     * @return bool|object
     */
    public static function current() {

        $date = date('Y-m-d');
        $currentCampaign = Campaign::where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();

        if (!$currentCampaign) {
            return false;
        }

        return $currentCampaign;
    }

}