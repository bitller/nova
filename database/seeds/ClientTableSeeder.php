<?php

use Illuminate\Database\Seeder;

/**
 * Seed clients table
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ClientTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\Client::class, 10)->create();
    }
}
