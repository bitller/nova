<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder {

    public function run() {
        factory(App\Language::class)->create(['key' => 'en', 'language' => 'English']);
    }

}