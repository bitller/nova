<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $this->call(ActionTableSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(CampaignTableSeeder::class);
        $this->call(NotificationTypeTableSeeder::class);
        $this->call(NotificationTableSeeder::class);
        $this->call(SecuritySettingTableSeeder::class);
        $this->call(UserDefaultSettingTableSeeder::class);
        $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
