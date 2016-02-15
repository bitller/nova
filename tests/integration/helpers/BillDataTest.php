<?php
use App\Helpers\BillData;

/**
 * Integration tests for BillData helper.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmial.com>
 */
class BillDataTest extends TestCase {

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
     * Make sure getBillPrice method works.
     */
    public function test_it_return_valid_bill_price() {

        $customProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();

        $firstBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $customProduct->id
        ]);

        $secondBillProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $applicationProduct->id
        ]);

        $thirdBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $customProduct->id
        ]);

        $expectedPrice = number_format($firstBillProduct->price + $secondBillProduct->price + $thirdBillProduct->price, 2);

        $this->assertEquals($expectedPrice, BillData::getBillPrice($this->bill->id));
    }

    /**
     * Make sure getBillNumberOfProducts method works.
     */
    public function test_it_return_valid_bill_number_of_products() {

        $customProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();

        factory(\App\BillProduct::class, 3)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $customProduct->id,
            'quantity' => 1
        ]);

        factory(\App\BillApplicationProduct::class, 4)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $applicationProduct->id,
            'quantity' => 2
        ]);

        $this->assertEquals(11, BillData::getNumberOfProducts($this->bill->id));
    }

    /**
     * Make sure getBillToPay method works.
     */
    public function test_it_return_valid_bill_to_pay() {

        $customProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();

        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $customProduct->id
        ]);

        $billApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $applicationProduct->id
        ]);

        $expected = number_format($billApplicationProduct->final_price + $billProduct->final_price, 2);

        $this->assertEquals($expected, BillData::getBillToPay($this->bill->id));
    }

    /**
     * Make sure getBillSavedMoney method works.
     */
    public function test_it_return_valid_bill_saved_money() {

        $customProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();

        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $customProduct->id
        ]);

        $billApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $applicationProduct->id
        ]);

        $savedMoney = number_format(($billApplicationProduct->price + $billProduct->price) - BillData::getBillToPay($this->bill->id), 2);

        $this->assertEquals($savedMoney, BillData::getBillSavedMoney($this->bill->id));
    }

    /**
     * Make sure getBillPriceFinalPriceToPaySavedMoneyAndNumberOfProducts method works.
     */
    public function test_it_return_valid_bill_price_final_price_saved_money_to_pay_and_number_of_products() {

        $customProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $customProduct->id
        ]);

        factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $applicationProduct->id
        ]);

        $billData = BillData::getBillPriceFinalPriceToPaySavedMoneyAndNumberOfProducts($this->bill->id);

        $this->assertEquals(BillData::getBillPrice($this->bill->id), $billData['price']);
        $this->assertEquals(BillData::getNumberOfProducts($this->bill->id), $billData['number_of_products']);
        $this->assertEquals(BillData::getBillToPay($this->bill->id), $billData['final_price']);
        $this->assertEquals(BillData::getBillSavedMoney($this->bill->id), $billData['saved_money']);
    }

    /**
     * Make sure getPaymentTerm method works.
     */
    public function test_it_return_valid_bill_payment_term() {

        // Test with bill that has payment term
        $this->assertEquals(date('d-m-Y', strtotime($this->bill->payment_term)), BillData::getPaymentTerm($this->bill->id));

        // Test with bill that does not have payment term
        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'payment_term' => ''
        ]);
        $this->assertEquals(false, BillData::getPaymentTerm($bill->id));
    }
}