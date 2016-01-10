<?php

/**
 * Integration tests for User model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserTest extends TestCase {

    public function test_admin_create_special_user() {

        // Generate user
        $generatedUser = factory(App\User::class)->create(['special_user' => true]);

        $this->seeInDatabase('users', [
            'email' => $generatedUser->email,
            'special_user' => true
        ]);
    }

    public function test_admin_create_user() {

        // Generate user
        $generatedUser = factory(App\User::class)->create();

        $this->seeInDatabase('users', [
            'email' => $generatedUser->email,
            'special_user' => false
        ]);

    }

}