<?php

use Illuminate\Database\Seeder;

/**
 * Seed user_default_settings table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserDefaultSettingTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\UserDefaultSetting::class)->create([
            'language_id' => 2
        ]);
    }
}
