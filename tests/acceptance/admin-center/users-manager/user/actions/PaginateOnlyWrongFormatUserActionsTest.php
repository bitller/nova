<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate only wrong format user actions admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateOnlyWrongFormatUserActionsTest extends TestCase {

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
     * Admin paginate only wrong format user actions.
     */
    public function test_admin_paginate_only_wrong_format_user_actions() {

        factory(\App\UserAction::class, 'wrong_format', 4)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 11)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get-actions/wrong_format')
            ->seeJson([
                'total' => 4
            ]);
    }

    /**
     * Admin paginate only wrong format user actions with not existent user id.
     */
    public function test_admin_paginate_only_wrong_format_user_actions_with_not_existent_user_id() {

        factory(\App\UserAction::class, 'wrong_format', 6)->create(['user_id' => $this->user->id]);
        factory(\App\UserAction::class, 11)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/str' . rand() . '/get-actions/wrong_format')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }
}