<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test mark bill as paid functionality.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MarkBillAsPaidTest extends TestCase {

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
     * @var null
     */
    private $bill = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);
    }

    /**
     * User mark empty and unpaid bill as paid.
     */
    public function test_user_mark_empty_and_unpaid_bill_as_paid() {

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/mark-as-paid')
            ->seeJson([
                'success' => true,
                'message' => trans('bill.marked_as_paid')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }

    /**
     * User mark not empty and unpaid bill as paid.
     */
    public function test_user_mark_not_empty_and_unpaid_bill_as_paid() {

        factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => factory(\App\ApplicationProduct::class)->create()->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/mark-as-paid')
            ->seeJson([
                'success' => true,
                'message' => trans('bill.marked_as_paid')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }

    /**
     * User mark empty and paid bill as paid.
     */
    public function test_user_mark_empty_and_paid_bill_as_paid() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'paid' => 1
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $bill->id . '/mark-as-paid')
            ->seeJson([
                'success' => true,
                'message' => trans('bill.marked_as_paid')
            ])
            ->seeInDatabase('bills', [
                'id' => $bill->id,
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }

    /**
     * User mark not empty and paid bill as paid.
     */
    public function test_user_mark_not_empty_and_paid_bill_as_paid() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'paid' => 1
        ]);

        factory(\App\BillApplicationProduct::class, 2)->create([
            'bill_id' => $bill->id,
            'product_id' => factory(\App\ApplicationProduct::class)->create()->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $bill->id . '/mark-as-paid')
            ->seeJson([
                'success' => true,
                'message' => trans('bill.marked_as_paid')
            ])
            ->seeInDatabase('bills', [
                'id' => $bill->id,
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }

    /**
     * User tries to mark as paid bill of another user.
     */
    public function test_user_mark_as_paid_bill_of_another_user() {

        $this->actingAs(factory(\App\User::class)->create())
            ->get('/bills/' . $this->bill->id . '/mark-as-paid')
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'paid' => 0
            ]);
    }

    /**
     * User tries to mark as paid not existent bill.
     */
    public function test_user_mark_as_paid_not_existent_bill() {

        $this->actingAs($this->user)
            ->get('/bills/str' . rand() . '/mark-as-paid')
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ]);
    }

    /**
     * Not logged in user tries to mark bill as paid.
     */
    public function test_not_logged_in_user_mark_bill_as_paid() {

        $this->get('/bills/' . $this->bill->id . '/mark-as-paid')
            ->seeStatusCode(302);
    }
}