<?php

class PaginatePaidUserBillsTest extends TestCase {

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
     * Test admin paginate user paid bills.
     */
    public function test_admin_paginate_user_paid_bills() {

        // Generate paid bills
        factory(App\Bill::class, 'paid', 4)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        // Also generate unpaid bills
        factory(App\Bill::class, 3)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get-paid-bills')
            ->seeJson([
                'total' => 4
            ]);
    }

    /**
     * Test admin paginate not existent user paid bills.
     */
    public function test_admin_paginate_not_existent_user_paid_bills() {

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . rand(1000, 9999) . '/get-paid-bills')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

}