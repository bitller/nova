<?php

use Illuminate\Database\Seeder;

/**
 * Seed notification_types table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NotificationTypeTableSeeder extends Seeder {
    
    /**
     * Seed table.
     */
    public function run() {
        factory(\App\NotificationType::class, 3)->create();
    }
    
}
