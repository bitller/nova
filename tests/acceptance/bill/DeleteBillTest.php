<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete bill feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteBillTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;

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
     * User delete empty bill.
     */
    public function test_user_delete_empty_bill() {

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete')
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * User delete not empty bill.
     */
    public function test_user_delete_not_empty_bill() {

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => factory(\App\Product::class)->create(['user_id' => $this->user->id])->id
        ]);

        factory(\App\BillApplicationProduct::class, 2)->create([
            'bill_id' => $this->bill->id,
            'product_id' => factory(\App\ApplicationProduct::class)->create()->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete')
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id
            ])
            ->notSeeInDatabase('bill_products', [
                'bill_id' => $this->bill->id
            ])
            ->notSeeInDatabase('bill_application_products', [
                'bill_id' => $this->bill->id
            ]);
    }

    /**
     * User tries to delete bill of another user.
     */
    public function test_user_delete_bill_of_another_user() {

        $this->actingAs(factory(\App\User::class)->create())
            ->get('/bills/' . $this->bill->id . '/delete')
            ->seeJson([
                'success' => false,
                'message' => trans('bills.bill_not_found')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * User tries to delete not existent bill.
     */
    public function test_user_delete_not_existent_bill() {

        $this->actingAs($this->user)
            ->get('/bills/str' . rand() . '/delete')
            ->seeJson([
                'success' => false,
                'message' => trans('bills.bill_not_found')
            ]);
    }
}