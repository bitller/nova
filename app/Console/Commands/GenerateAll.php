<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * Delete and generate an entire new data set for the application
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class GenerateAll extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new data set for the application';

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

        $this->info('Creating a new data set for the application...');

        Artisan::call('migrate:refresh --seed');
        $this->info('Database rolled back and seeded again');

//        Artisan::call('migrate');
//        $this->info('Tables migrated again.');

//        Artisan::call('generate:roles');
//        $this->info('Generated user roles.');

//        Artisan::call('generate:log_types');
//        $this->info('Generated log types.');

//        Artisan::call('db:seed');
//        $this->info('Seeded tables.');

//        Artisan::call('generate:admin');
//        $this->info('Generated an admin user with default credentials.');
    }
}
