<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate bills feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateBillsTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @var null
     */
    private $user = null;

    /**
     * @var null
     */
    private $client = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * User paginate their bills.
     */
    public function test_paginate_only_one_bill() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/get')
            ->seeJson([
                'total' => 1
            ]);
    }

    /**
     * User paginate bills with more pages.
     */
    public function test_paginate_multiple_pages_bills() {

        factory(\App\Bill::class, 17)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/get')
            ->seeJson([
                'total' => 17,
                'per_page' => \App\Helpers\Settings::displayedBills()
            ]);
    }

    /**
     * Not logged in user tries to paginate bills.
     */
    public function test_paginate_bills_as_not_logged_in_user() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->get('/bills/get')
            ->seeStatusCode(302);
    }
}