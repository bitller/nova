<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateLoginAttemptsTable migration
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateLoginAttemptsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('login_attempts', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('ip');
            $table->string('client');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('login_attempts');
    }
}
