<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete only allowed user actions admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteOnlyAllowedUserActionsTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * @var null
     */
    private $admin = null;

    /**
     * @var null
     */
    private $user = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(\App\User::class, 'admin')->create();
        $this->user = factory(\App\User::class)->create();
    }

    /**
     * Admin delete only allowed user actions.
     */
    public function test_admin_delete_only_allowed_user_actions() {

        factory(\App\UserAction::class, 10)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/allowed')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->notSeeInDatabase('user_actions', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin delete only allowed user actions when user has no action.
     */
    public function test_admin_delete_only_allowed_user_actions_when_user_has_no_action() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/allowed')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->notSeeInDatabase('user_actions', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin delete only allowed user actions when user has no allowed action.
     */
    public function test_admin_delete_only_allowed_user_actions_when_user_has_no_allowed_actions() {

        factory(\App\UserAction::class, 'info', 7)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'wrong_format', 4)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'not_allowed', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/allowed')
            ->assertEquals(15, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin tries to delete only allowed user actions with not existent user id.
     */
    public function test_admin_delete_only_allowed_user_actions_with_not_existent_user_id() {

        factory(\App\UserAction::class, 'info', 4)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 6)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-actions/allowed')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(10, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin tries to delete only allowed user actions with not existent user id in string format.
     */
    public function test_admin_delete_only_allowed_user_actions_with_not_existent_user_id_in_string_format() {

        factory(\App\UserAction::class, 'wrong_format', 5)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 5)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/string' . rand() . '/delete-actions/allowed')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(10, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Normal user tries to delete only allowed user actions.
     */
    public function test_normal_user_delete_only_allowed_user_actions() {

        factory(\App\UserAction::class, 5)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'wrong_format', 5)->create(['user_id' => $this->user->id]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/allowed')
            ->assertEquals(10, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Not logged in user tries to delete only allowed user actions.
     */
    public function test_not_logged_in_user_delete_only_allowed_user_actions() {

        factory(\App\UserAction::class, 5)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'info', 5)->create(['user_id' => $this->user->id]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/allowed')
            ->assertEquals(10, \App\UserAction::where('user_id', $this->user->id)->count());
    }
}