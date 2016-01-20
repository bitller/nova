<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test delete bill functionality.
 *
 * @author Alexandru Bugarin <alexadru.bugarin@gmail.com>
 */
class DeleteBillTest extends TestCase {

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
     * Current logged in user delete one of his bills.
     */
    public function test_user_delete_bill() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $bill->id . '/delete')
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'id' => $bill->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * User tries to delete bill of another user.
     */
    public function test_delete_bill_of_another_user() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->get('/bills/' . $bill->id . '/delete')
            ->seeJson([
                'success' => false,
                'message' => trans('bills.bill_not_found')
            ])
            ->seeInDatabase('bills', [
                'id' => $bill->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * User tries to delete not existent bill.
     */
    public function test_delete_not_existent_bill() {

        $this->actingAs($this->user)
            ->get('/bills/str' . rand() . '/delete')
            ->seeJson([
                'success' => false,
                'message' => trans('bills.bill_not_found')
            ]);
    }

    /**
     * Not logged in user tries to delete bill of another user.
     */
    public function test_not_logged_in_user_delete_bill() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->get('/bills/' . $bill->id . '/delete')
            ->seeStatusCode(302)
            ->seeInDatabase('bills', [
                'id' => $bill->id,
                'user_id' => $this->user->id
            ]);
    }
}