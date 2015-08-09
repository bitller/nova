<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateLogsTable migration
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateLogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('logs', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->bigInteger('log_type_id')->unsigned();

            $table->foreign('log_type_id')->references('id')->on('log_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('logs');
    }
}
