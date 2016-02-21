<?php

use Illuminate\Database\Seeder;

/**
 * Seed notifications table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NotificationTableSeeder extends Seeder {
    
    /**
     * Seed table.
     */
    public function run() {

        $types = \App\NotificationType::all();

        foreach ($types as $type) {
            factory(\App\Notification::class)->create([
                'notification_type_id' => $type->id,
                'targeted_user_id' => \App\TargetedUser::where('key', 'none')->first()->id
            ]);
        }

    }
    
}
