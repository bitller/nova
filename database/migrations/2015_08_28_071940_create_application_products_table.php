<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateApplicationProductsTable migration
 *
 * @auhtor Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateApplicationProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('application_products', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code', 5);
            $table->enum('default', [0, 1])->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('application_products');
    }
}
