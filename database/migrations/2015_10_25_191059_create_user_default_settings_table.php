<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUserDefaultSettingsTable migration
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateUserDefaultSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_default_settings', function(Blueprint $table) {

            $table->smallIncrements('id');
            $table->tinyInteger('displayed_bills')->default(10);
            $table->tinyInteger('displayed_clients')->default(10);
            $table->tinyInteger('displayed_products')->default(10);
            $table->tinyInteger('displayed_custom_products')->default(10);
            $table->smallInteger('language_id')->unsigned();

            $table->timestamps();

            $table->foreign('language_id')->references('id')->on('languages')->onUpadate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('user_default_settings');
    }
}
