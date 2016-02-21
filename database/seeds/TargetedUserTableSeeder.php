<?php

use Illuminate\Database\Seeder;

/**
 * Seed targeted_users table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class TargetedUserTableSeeder extends Seeder {
    
    /**
     * Seed table.
     */
    public function run() {

        $data = [
            [
                'key' => 'none',
                'name' => 'None'
            ],
            [
                'key' => 'all',
                'name' => 'all'
            ]
        ];

        DB::table('targeted_users')->insert($data);
    }
    
}
