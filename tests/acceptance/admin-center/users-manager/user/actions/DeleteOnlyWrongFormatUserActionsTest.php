<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete only wrong format user actions admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteOnlyWrongFormatUserActions extends TestCase {

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
     * Admin delete only wrong format user actions.
     */
    public function test_admin_delete_only_wrong_format_user_actions() {

        factory(\App\UserAction::class, 'wrong_format', 3)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'info', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/wrong_format')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->assertEquals(4, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin delete only wrong format user actions when user has not action.
     */
    public function test_admin_delete_only_wrong_format_user_actions_when_user_has_no_action() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/wrong_format')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ]);
    }

    /**
     * Admin delete only wrong format user actions when user has no wrong format action.
     */
    public function test_admin_delete_only_wrong_format_user_actions_when_user_has_no_wrong_format_action() {

        factory(\App\UserAction::class, 'info', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/wrong_format')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_actions_deleted')
            ])
            ->assertEquals(4, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin tries to delete only wrong format user actions with not existent user id.
     */
    public function test_admin_delete_only_wrong_format_user_actions_with_not_existent_user_id() {

        factory(\App\UserAction::class, 'wrong_format', 7)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-actions/wrong_format')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(7, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin tries to delete only wrong format user actions with not existent user id.
     */
    public function test_admin_delete_only_wrong_format_user_actions_with_not_existent_user_id_as_string() {

        factory(\App\UserAction::class, 'wrong_format', 9)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/string' . rand() . '/delete-actions/wrong_format')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(9, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Normal user tries to delete only wrong format user actions.
     */
    public function test_normal_user_delete_only_wrong_format_user_actions() {

        factory(\App\UserAction::class, 'wrong_format', 3)->create(['user_id' => $this->user->id]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/wrong_format')
            ->assertEquals(3, \App\UserAction::where('user_id', $this->user->id)->count());
    }

    /**
     * Not logged in user tries to delete only wrong format user actions.
     */
    public function test_not_logged_in_user_delete_only_wrong_format_user_actions() {

        factory(\App\UserAction::class, 4)->create(['user_id' => $this->user->id]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-actions/wrong_format')
            ->assertEquals(4, \App\UserAction::where('user_id', $this->user->id)->count());
    }
}