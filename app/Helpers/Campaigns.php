<?php

namespace App\Helpers;

use App\Bill;
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

    /**
     * Auto determine order number for given client.
     *
     * @param object $campaign
     * @param int $clientId
     * @return int
     */
    public static function autoDetermineOrderNumber($campaign, $clientId) {

        $query = Bill::where('campaign_id', $campaign->id)->where('client_id', $clientId)->max('campaign_order');

        if (!$query) {
            return 1;
        }

        return $query + 1;
    }

}