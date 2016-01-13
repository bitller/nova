<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test paginate users bills admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateUnpaidUserBillsTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @var null
     */
    private $admin = null;

    /**
     * @var null
     */
    private $user = null;

    /**
     * @var null
     */
    private $client = null;

    /**
     * Called first.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(App\User::class, 'admin')->create();
        $this->user = factory(App\User::class)->create();
        $this->client = factory(App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * Admin paginate user unpaid bills.
     */
    public function test_admin_paginate_user_unpaid_bills() {

        // Generate bills
        factory(App\Bill::class, 4)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get')
            ->seeJson([
                'total' => 4
            ]);
    }

    /**
     * Admin paginate user unpaid bills.
     */
    public function test_admin_paginate_not_existent_user_unpaid_bills() {

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . rand(1000, 9999) . '/get')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

}