<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateLogTypesTable migration
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateLogTypesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('log_types', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('log_types');
    }
}
