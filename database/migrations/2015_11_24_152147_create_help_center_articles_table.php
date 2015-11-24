<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateHelpCenterArticlesTable migration.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateHelpCenterArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('help_center_articles', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('content');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('help_center_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('help_center_articles');
    }
}
