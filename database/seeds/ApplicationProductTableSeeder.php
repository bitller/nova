<?php

use Illuminate\Database\Seeder;

/**
 * Seeds application_products table
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ApplicationProductTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $products = 50;

        for ($i = 0; $i < $products; $i++) {
            factory(App\ApplicationProduct::class)->create();
        }
    }
}
