<?php

use Illuminate\Database\Seeder;

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

        factory(App\QuestionCategory::class)->create(['name' => 'first category']);
        factory(App\QuestionCategory::class)->create(['name' => 'second category']);

        // Generate users
        factory(App\User::class, 2)->create()->each(function($user) {

            // Settings
            $user->settings()->save(factory(App\UserSetting::class)->make(['user_id' => $user->id, 'language_id' => 1]));

            // Bills per user
            $rows = 12;

            // Products per bill
            $productsPerBill = 5;

            for ($i = 0; $i < $rows; $i++) {

                // Generate client
                $client = $user->clients()->save(factory(App\Client::class)->make());

                // Generate bill for that client
                $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

                // Generate products
                for ($j = 0; $j < $productsPerBill; $j++) {
                    $product = $user->products()->save(factory(App\Product::class)->make());
                    $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

                    $applicationProduct = factory(App\ApplicationProduct::class)->create();
                    $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $applicationProduct->id]));
                }

            }

        });
    }
}
