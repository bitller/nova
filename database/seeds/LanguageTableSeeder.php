<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LanguageTableSeeder extends Seeder {

    public function run() {
        factory(App\Language::class)->create(['key' => 'en', 'language' => 'English']);
        factory(App\Language::class)->create(['key' => 'ro', 'language' => 'Romana']);
    }

}