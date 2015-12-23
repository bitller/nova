<?php

use Illuminate\Database\Seeder;

/**
 * Seed actions table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ActionTableSeeder extends Seeder {

    /**
     * Seed table.
     */
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