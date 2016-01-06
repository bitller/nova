<?php

/**
 * Seeds offers table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class OfferTableSeeder extends \Illuminate\Database\Seeder {

    /**
     * Run table seeds.
     */
    public function run() {
        factory(App\Offer::class)->create(['use_on_sign_up' => true]);
    }
}