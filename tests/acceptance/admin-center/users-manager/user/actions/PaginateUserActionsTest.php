<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate user actions admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateUserActionsTest extends TestCase {

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
     * Admin paginate user actions.
     */
    public function test_admin_paginate_user_actions() {

        factory(\App\UserAction::class, 10)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'info', 4)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'wrong_format', 6)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get-actions/all')
            ->seeJson([
                'total' => 20
            ]);
    }

    /**
     * Admin paginate user actions with not allowed action name.
     */
    public function test_admin_paginate_user_actions_with_not_allowed_action_name() {

        factory(\App\UserAction::class, 10)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 5)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get-actions/wrong_action_name')
            ->seeJson([
                'total' => 15
            ]);
    }

    /**
     * Admin paginate user actions with not existent user id.
     */
    public function test_admin_paginate_user_actions_with_not_existent_user_id() {

        factory(\App\UserAction::class, 14)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/str' . rand() . '/get-actions/all')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }
}