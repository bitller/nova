<?php

namespace App\Console\Commands;

use App\Helpers\Roles;
use App\User;
use App\UserSetting;
use Illuminate\Console\Command;

/**
 * Insert an admin user in database
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class GenerateAdmin extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin {first_name=Alex} {last_name=Bugarin} {email=alexandru.bugarin@gmail.com} {password=123456}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert in database an admin user';

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

        $roles = new Roles();

        $user = new User();
        $user->first_name = $this->argument('first_name');
        $user->last_name = $this->argument('last_name');
        $user->email = $this->argument('email');
        $user->password = bcrypt($this->argument('password'));
        $user->role_id = $roles->getAdminRoleId();
        $user->save();

        $settings = new UserSetting();
        $settings->user_id = $user->id;
        $settings->language_id = 1;
        $settings->save();

        $this->info('User with admin privileges was generated');

    }
}
