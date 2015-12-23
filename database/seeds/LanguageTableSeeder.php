<?php

use Illuminate\Database\Seeder;

/**
 * Seeds languages table.
 *
 * @author Alexandru Bguarin <alexandru.bugarin@gmail.com>
 */
class LanguageTableSeeder extends Seeder {

    /**
     * Run table seeds.
     */
    public function run() {
        factory(App\Language::class)->create(['key' => 'en', 'language' => 'English']);
        factory(App\Language::class)->create(['key' => 'ro', 'language' => 'Romana']);
    }
}