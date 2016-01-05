<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateOffersTable migration.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateOffersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('offers', function(Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('paymill_offer_id');
            $table->string('name');
            $table->unsignedInteger('amount');
            $table->string('interval');
            $table->string('currency');
            $table->string('promo_code');
            $table->boolean('disabled')->default(true);
            $table->boolean('use_on_sign_up')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('offers');
    }
}
