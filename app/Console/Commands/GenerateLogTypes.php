<?php

namespace App\Console\Commands;

use App\Helpers\LogTypes;
use App\LogType;
use Illuminate\Console\Command;

/**
 * Populate log_types table
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class GenerateLogTypes extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:log_types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate log types';

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

        $logTypesHelper = new LogTypes();
        $logTypes = $logTypesHelper->getLogTypes();

        foreach($logTypes as $key => $value) {

            $logType = new LogType();
            $logType->key = $key;
            $logType->description = $value;
            $logType->save();

        }

    }
}
