<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/**
 * Seeds users table
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Generate users
        factory(App\User::class, 2)->create()->each(function($u) {

            $rows = 30;
            $faker = Faker::create();

            for ($i = 0; $i < $rows; $i++) {
                $client = $u->clients()->save(factory(App\Client::class)->make());
                $u->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));
            }

        });
    }
}
