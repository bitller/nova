<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder {

    public function run() {
        factory(App\Language::class)->create(['key' => 'en', 'language' => 'English']);
        factory(App\Language::class)->create(['key' => 'ro', 'language' => 'Romana']);
    }

}