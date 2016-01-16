<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate only allowed user actions admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateOnlyAllowedUserActionsTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMIddleware;

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
     * Admin paginate only allowed user actions.
     */
    public function test_admin_paginate_only_allowed_user_actions_test() {

        factory(\App\UserAction::class, 'info', 8)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'wrong_format',  15)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 11)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get-actions/allowed')
            ->seeJson([
                'total' => 11
            ]);
    }

    /**
     * Admin tries to paginate only allowed user actions with not existent user id.
     */
    public function test_admin_paginate_only_allowed_user_actions_with_not_existent_user_id() {

        factory(\App\UserAction::class, 'not_allowed', 12)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . rand(1000, 9999) . '/get-actions/allowed')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }
}