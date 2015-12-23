<?php

use Illuminate\Database\Seeder;

/**
 * Seeds roles table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RoleTableSeeder extends Seeder {

    /**
     * Run table seeds.
     */
    public function run() {
        $roles = [
            [
                'name' => 'Admin',
                'level' => 1
            ],
            [
                'name' => 'Moderator',
                'level' => 2
            ],
            [
                'name' => 'User',
                'level' => 3
            ]
        ];

        foreach ($roles as $role) {
            $roleModel = new \App\Role();
            $roleModel->name = $role->name;
            $roleModel->level = $role->level;
            $roleModel->save();
        }
    }

}