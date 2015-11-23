<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateHelpCenterCategoriesTable migration.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateHelpCenterCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('help_center_categories', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('help_center_categories');
    }
}
