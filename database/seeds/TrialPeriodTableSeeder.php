<?php

use Illuminate\Database\Seeder;

/**
 * Seeds trial_periods table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class TrialPeriodTableSeeder extends Seeder {
    
    /**
     * Seed table.
     */
    public function run() {

        $trials = [
            [
                'name' => '0 day - for testing only',
                'validity_days' => 0,
                'active' => 1
            ],
            [
                'name' => '90 days free',
                'validity_days' => 90,
                'active' => 1
            ]
        ];

        foreach ($trials as $trial) {

            $trialPeriod = new \App\TrialPeriod();
            $trialPeriod->name = $trial['name'];
            $trialPeriod->validity_days = $trial['validity_days'];
            $trialPeriod->active = $trial['active'];

            $trialPeriod->save();
        }
    }
    
}
