<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateApplicationLogsTable migration
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateApplicationLogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('application_logs', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('message');
            $table->string('ip');
            $table->integer('log_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('log_type_id')->references('id')->on('log_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('application_logs');
    }
}
