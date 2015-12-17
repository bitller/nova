<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUserActionsTable migration.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateUserActionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_actions', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->smallInteger('action_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('user_actions');
    }
}
