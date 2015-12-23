<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ActionTableSeeder extends Seeder {

    public function run() {

        $actions = [
            [
                'type' => 'allowed',
                'name' => 'Allowed'
            ],
            [
                'type' => 'info',
                'name' => 'info'
            ],
            [
                'type' => 'wrong_format',
                'name' => 'Wrong format'
            ],
            [
                'type' => 'not_allowed',
                'name' => 'Not allowed'
            ]
        ];

        foreach ($actions as $action) {
            factory(App\Action::class)->create($action);
        }

    }

}