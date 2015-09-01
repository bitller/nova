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
        factory(App\User::class, 2)->create()->each(function($user) {

            // Bills per user
            $rows = 12;

            // Products per bill
            $productsPerBill = 5;

            for ($i = 0; $i < $rows; $i++) {

                // Generate client
                $client = $user->clients()->save(factory(App\Client::class)->make());

                // Generate bill for that client
                $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

                // Generate products
                for ($j = 0; $j < $productsPerBill; $j++) {
                    $user->products()->save(factory(App\Product::class)->make());
                }

            }

        });
    }
}
