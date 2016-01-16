<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate user clients admin feature.
 *
 * @author Alexandru Bugarin <alexandruu.bugarin@gmail.com>
 */
class PaginateUserClientsTest extends TestCase {

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
     * Admin paginate user clients.
     */
    public function test_admin_paginate_user_clients() {

        factory(\App\Client::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get-clients')
            ->seeJson([
                'total' => 4
            ]);
    }

    /**
     * Admin tries to paginate clients of not existent user.
     */
    public function test_admin_paginate_user_clients_with_not_existent_user_id() {

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . rand(1000, 9999) . '/get-clients')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }
}