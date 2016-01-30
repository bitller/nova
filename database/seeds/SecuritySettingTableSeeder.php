<?php

use Illuminate\Database\Seeder;

/**
 * Seeds security_settings table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SecuritySettingTableSeeder extends Seeder {

    /**
     * Seed table.
     */
    public function run() {

        $currentCampaign = \App\Helpers\Campaigns::current();

        factory(\App\SecuritySetting::class)->create([
            'current_campaign_id' => $currentCampaign->id
        ]);
    }

}