<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate only info user actions admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateOnlyInfoUserActionsTest extends TestCase {

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
     * Admin paginate only info user actions.
     */
    public function test_admin_paginate_only_info_user_actions() {

        factory(\App\UserAction::class, 11)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'info', 4)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/get-actions/info')
            ->seeJson([
                'total' => 11
            ]);
    }

    /**
     * Admin tries to paginate only info user actions with not existent user id.
     */
    public function test_admin_paginate_only_info_user_actions_with_not_existent_user_id() {

        factory(\App\UserAction::class, 3)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 'wrong_format')->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/get-actions/info')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }
}