<?php
use App\Helpers\BillData;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test get bill data feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class GetBillDataTest extends TestCase {

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
     * User get bill data.
     */
    public function test_get_empty_bill_data() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $bill->id . '/get')
            ->seeJson([
                'to_pay' => BillData::getBillToPay($bill->id),
                'saved_money' => BillData::getBillSavedMoney($bill->id),
                'total' => BillData::getBillPrice($bill->id),
                'number_of_products' => BillData::getNumberOfProducts($bill->id),
            ]);
    }

    /**
     * User get data of bill with products.
     */
    public function test_get_bill_with_products() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        factory(\App\BillProduct::class, 3)->create([
            'bill_id' => $bill->id,
            'product_id' => factory(\App\Product::class)->create(['user_id' => $this->user->id])->id
        ]);

        factory(\App\BillApplicationProduct::class, 4)->create([
            'bill_id' => $bill->id,
            'product_id' => factory(\App\ApplicationProduct::class)->create()->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $bill->id . '/get')
            ->seeJson([
                'to_pay' => BillData::getBillToPay($bill->id),
                'saved_money' => BillData::getBillSavedMoney($bill->id),
                'total' => BillData::getBillPrice($bill->id),
                'number_of_products' => BillData::getNumberOfProducts($bill->id)
            ]);
    }

    /**
     * User tries to get data of not existent bill.
     */
    public function test_get_not_existent_bill() {

        $this->actingAs($this->user)
            ->get('/bills/str' . rand() . '/get')
            ->seeJson([
                'success' => false,
                'message' => trans('bills.bill_not_found')
            ]);
    }

    /**
     * User tries to get data of bill that belongs to another user.
     */
    public function test_get_bill_of_another_user() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        factory(\App\BillApplicationProduct::class, 4)->create([
            'bill_id' => $bill->id,
            'product_id' => factory(\App\ApplicationProduct::class)->create()->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->get('/bills/' . $bill->id . '/get')
            ->seeJson([
                'success' => false,
                'message' => trans('bills.bill_not_found')
            ]);
    }

    /**
     * User tries to get data of empty bill that belongs to another user.
     */
    public function test_get_empty_bill_of_another_user() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->get('/bills/' . $bill->id . '/get')
            ->seeJson([
                'success' => false,
                'message' => trans('bills.bill_not_found')
            ]);
    }

    /**
     * Not logged in user tries to get bill data.
     */
    public function test_not_logged_in_user_get_bill() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => factory(\App\ApplicationProduct::class)->create()->id
        ]);

        $this->get('/bills/' . $bill->id . '/get')
            ->seeStatusCode(302);
    }
}