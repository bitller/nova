<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete only not allowed user actions admin functionality.
 *
 * @author Alexandru Bugairn <alexandru.bugarin@gmail.com>
 */
class DeleteOnlyNotAllowedUserActionsTest extends TestCase {

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
     * Admin delete only not allowed user actions.
     */
    public function test_admin_delete_only_not_allowed_user_actions() {

        factory(\App\UserAction::class, 'not_allowed', 5)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'info', 6)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/not_allowed')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->assertEquals(6, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin delete only not allowed user actions when user has no action.
     */
    public function test_admin_delete_only_not_allowed_user_actions_when_user_has_no_action() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/not_allowed')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ]);
    }

    /**
     * Admin delete only not allowed user actions when user has no not allowed action.
     */
    public function test_admin_delete_only_not_allowed_user_actions_when_user_has_no_not_allowed_action() {

        factory(\App\UserAction::class, 'info', 9)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/not_allowed')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->assertEquals(9, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin delete only not allowed user actions with not existent user id.
     */
    public function test_admin_delete_only_not_allowed_user_actions_with_not_existent_user_id() {

        factory(\App\UserAction::class, 'not_allowed', 7)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-actions/not_allowed')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(7, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin delete only not allowed user actions with not existent user id as string.
     */
    public function test_admin_delete_only_not_allowed_user_actions_with_not_existent_user_id_as_string() {

        factory(\App\UserAction::class, 'not_allowed', 8)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/string' . rand() . '/delete-actions/not_allowed')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(8, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Normal user tries to delete only not allowed user actions.
     */
    public function test_normal_user_delete_only_not_allowed_user_actions() {

        factory(\App\UserAction::class, 'not_allowed', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/not_allowed')
            ->assertEquals(4, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Not logged in user tries to delete only not allowed user actions.
     */
    public function test_not_logged_in_user_delete_only_not_allowed_user_actions() {

        factory(\App\UserAction::class, 'not_allowed', 6)->create(['user_id' => $this->user->id]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/not_allowed')
            ->assertEquals(6, \App\UserAction::where('user_id', $this->user->id)->count());
    }
}