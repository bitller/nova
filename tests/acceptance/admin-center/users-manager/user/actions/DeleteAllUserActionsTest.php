<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete all user actions admin feature.
 *
 * @author Alexandru.bugarin@gmail.com>
 */
class DeleteAllUserActionsTest extends TestCase {

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
     * Admin delete all user actions.
     */
    public function test_admin_delete_all_user_actions() {

        // Generate allowed actions
        factory(\App\UserAction::class, 3)->create(['user_id' => $this->user->id]);

        // Generate wrong format actions
        factory(\App\UserAction::class, 'wrong_format', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/all')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->notSeeInDatabase('user_actions', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin delete user actions when user has no action.
     */
    public function test_admin_delete_all_user_actions_when_user_has_no_action() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/all')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->notSeeInDatabase('user_actions', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete all user actions with not existent user id.
     */
    public function test_admin_delete_all_user_actions_with_not_existent_user_id() {

        // Generate allowed actions
        factory(\App\UserAction::class, 3)->create(['user_id' => $this->user->id]);

        // Generate info actions
        factory(\App\UserAction::class, 'info', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-actions/all')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Admin tries to delete all user actions with not existent user id in string format.
     */
    public function test_admin_delete_all_user_actions_with_not_existent_user_id_in_string_format() {

        // Generate allowed actions
        factory(\App\UserAction::class, 3)->create(['user_id' => $this->user->id]);

        // Generate not allowed actions
        factory(\App\UserAction::class, 'not_allowed', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/string' . rand() . '/delete-actions/all')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Normal user tries to delete all user actions.
     */
    public function test_normal_user_delete_all_user_actions() {

        // Generate info actions
        factory(\App\UserAction::class, 'info', 4)->create(['user_id' => $this->user->id]);

        // Generate wrong format actions
        factory(\App\UserAction::class, 'wrong_format', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/all')
            ->assertEquals(8, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Not logged in user tries to delete all user actions.
     */
    public function test_not_logged_in_user_delete_all_user_actions() {

        // Generate wrong format actions
        factory(\App\UserAction::class, 'wrong_format', 4)->create(['user_id' => $this->user->id]);

        // Generate not allowed actions
        factory(\App\UserAction::class, 'not_allowed', 13)->create(['user_id' => $this->user->id]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/all')
            ->assertEquals(17, \App\UserAction::where('user_id', $this->user->id)->count());
    }
}