<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUserSettings migration
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateUserSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_settings', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('displayed_bills')->default(10);
            $table->tinyInteger('displayed_clients')->default(10);
            $table->tinyInteger('displayed_products')->default(10);
            $table->tinyInteger('displayed_custom_products')->default(10);
            $table->smallInteger('language_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('user_settings');
    }
}
