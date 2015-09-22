<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateBillApplicationProductsTable migration
 *
 * @author Alexandru Bugarin <alexadru.bugarin@gmail.com>
 */
class CreateBillApplicationProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('bill_application_products', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('bill_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->smallInteger('page')->default(4);
            $table->tinyInteger('quantity');
            $table->float('price');
            $table->tinyInteger('discount');
            $table->timestamps();

            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('application_products')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('bill_application_products');
    }
}
