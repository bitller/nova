<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateActionsTable migrations.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateActionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('actions', function(Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('type');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('actions');
    }
}
