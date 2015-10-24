<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateLanguagesTable migration
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateLanguagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('languages', function(Blueprint $table) {

            $table->smallIncrements('id');
            $table->string('key');
            $table->string('language');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('languages');
    }
}
