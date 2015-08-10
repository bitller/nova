<?php

namespace App\Console\Commands;

use App\Role;
use Illuminate\Console\Command;

/**
 * Insert in database user roles
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class GenerateRoles extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate user roles';

    /**
     * User roles to insert in database
     *
     * @var array
     */
    protected $roles = [
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

    /**
     * Create a new command instance.
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        foreach ($this->roles as $role) {
            $roleModel = new Role();
            $roleModel->name = $role['name'];
            $roleModel->level = $role['level'];
            $roleModel->save();
        }

        $this->info('User roles generated with success');

    }
}
