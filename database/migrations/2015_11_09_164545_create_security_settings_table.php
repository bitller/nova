<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateSecuritySettingsTable migration
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateSecuritySettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('security_settings', function(Blueprint $table) {
            $table->smallIncrements('id');
            $table->tinyInteger('recover_code_valid_minutes')->unsigned()->default(30);
            $table->smallInteger('login_attempts')->unsigned()->default(5);
            $table->enum('allow_new_accounts', [1,0])->default(1);
            $table->enum('allow_users_to_change_language', [1,0])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('security_settings');
    }
}
