<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateProductsTable migration
 *
 * @author Alexandru Bugarin <alexandru.bugairn@gmail.com>
 */
class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code', 5);
            $table->bigInteger('user_id')->unsigned();
            $table->enum('default', [0, 1])->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
}
