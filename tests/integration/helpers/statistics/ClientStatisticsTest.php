<?php
use App\Helpers\Statistics\ClientStatistics;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for ClientStatistics helper.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ClientStatisticsTest extends TestCase {

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
     * @var null
     */
    private $product = null;

    /**
     * @var null
     */
    private $secondProduct = null;

    /**
     * @var null
     */
    private $applicationProduct = null;

    /**
     * @var null
     */
    private $secondApplicationProduct = null;

    /**
     * @var null
     */
    private $billProduct = null;

    /**
     * @var null
     */
    private $secondBillProduct = null;

    /**
     * @var null
     */
    private $billApplicationProduct = null;

    /**
     * @var null
     */
    private $secondBillApplicationProduct = null;

    /**
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();

        // Generate user, client and bill
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'paid' => 1,
            'campaign_id' => \App\Helpers\Campaigns::current()->id
        ]);

        // Generate products and application products
        $this->product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $this->secondProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $this->applicationProduct = factory(\App\ApplicationProduct::class)->create();
        $this->secondApplicationProduct = factory(\App\ApplicationProduct::class)->create();

        // Generate bill products
        $this->billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $this->product->id
        ]);
        $this->secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $this->secondProduct->id
        ]);

        // Generate bill application products
        $this->billApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $this->applicationProduct->id
        ]);
        $this->secondBillApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $this->secondApplicationProduct->id
        ]);
    }

    /**
     * Test earnings method works correctly.
     */
    public function test_get_client_earnings() {

        // Calculate expected earnings
        $expectedEarnings = 0;
        $expectedEarnings += ($this->billProduct->final_price);
        $expectedEarnings += ($this->secondBillProduct->final_price);
        $expectedEarnings += ($this->billApplicationProduct->final_price);
        $expectedEarnings += ($this->secondBillApplicationProduct->final_price);
        $expectedEarnings = number_format($expectedEarnings, 2);

        $this->assertEquals($expectedEarnings, ClientStatistics::earnings($this->client->id));
    }

    /**
     * Make sure totalDiscountReceived method works.
     */
    public function test_get_total_discount_received() {

        // Create user, client and bill
        $user = factory(\App\User::class)->create();
        $client = factory(\App\Client::class)->create(['user_id' => $user->id]);
        $bill = factory(\App\Bill::class)->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'paid' => 1
        ]);

        // Create another paid bill
        $secondBill = factory(\App\Bill::class)->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'paid' => 1
        ]);

        // Create also one unpaid bill
        $unpaidBill = factory(\App\Bill::class)->create([
            'user_id' => $user->id,
            'client_id' => $client->id
        ]);

        // Create some products
        $product = factory(\App\Product::class)->create(['user_id' => $user->id]);
        $secondProduct = factory(\App\Product::class)->create(['user_id' => $user->id]);
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();

        // Add product to bill
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id,
            'price' => 100,
            'final_price' => 90,
            'discount' => 10,
            'quantity' => 2
        ]);

        // Add another product to bill
        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $secondProduct->id,
            'price' => 100,
            'final_price' => 90,
            'discount' => 10,
            'quantity' => 1
        ]);

        // Add product to second bill
        $thirdBillProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $secondBill->id,
            'product_id' => $applicationProduct->id,
            'price' => 100,
            'final_price' => 90,
            'discount' => 10,
            'quantity' => 3
        ]);

        // Add also one product to the unpaid bill
        $fourthBillProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $unpaidBill->id,
            'product_id' => $applicationProduct->id,
            'price' => 90,
            'discount' => 10,
            'quantity' => 2
        ]);

        $expected = ($billProduct->price - $billProduct->final_price) * $billProduct->quantity;
        $expected += ($secondBillProduct->price - $secondBillProduct->final_price) * $secondBillProduct->quantity;
        $expected += ($thirdBillProduct->price - $thirdBillProduct->final_price) * $thirdBillProduct->quantity;

        $this->assertEquals($expected, ClientStatistics::totalDiscountReceived($client->id));
    }

    /**
     * Test totalNumberOfProductsOrdered method works.
     */
    public function test_get_client_number_of_ordered_products() {

        $expected = $this->billProduct->quantity + $this->secondBillProduct->quantity;
        $expected += $this->billApplicationProduct->quantity + $this->secondBillApplicationProduct->quantity;

        $this->assertEquals($expected, ClientStatistics::totalNumberOfProductsOrdered($this->client->id));
    }

    /**
     * Make sure all method works as expected.
     */
    public function test_all_client_statistics_method() {

        // Calculate expected earnings
        $expectedEarnings = $this->billProduct->final_price + $this->secondBillProduct->final_price;
        $expectedEarnings += $this->billApplicationProduct->final_price + $this->secondBillApplicationProduct->final_price;
        $expectedEarnings = number_format($expectedEarnings, 2);

        // Calculate earnings in current campaign
        $expectedEarningsInCurrentCampaign = 0;

        // Calculate money user has to receive
        $expectedMoneyUserHasToReceive = 0;

        // Calculate number of products ordered
        $expectedNumberOfProductsOrdered = $this->billProduct->quantity + $this->secondBillProduct->quantity;
        $expectedNumberOfProductsOrdered += $this->billApplicationProduct->quantity + $this->secondBillApplicationProduct->quantity;

        // Calculate total discount received
        $expectedDiscountReceived = ($this->billProduct->price - $this->billProduct->final_price) * $this->billProduct->quantity;
        $expectedDiscountReceived += ($this->secondBillProduct->price - $this->secondBillProduct->final_price) * $this->secondBillProduct->quantity;
        $expectedDiscountReceived += ($this->billApplicationProduct->price - $this->billApplicationProduct->final_price) * $this->billApplicationProduct->quantity;
        $expectedDiscountReceived += ($this->secondBillApplicationProduct->price - $this->secondBillApplicationProduct->final_price) * $this->secondBillApplicationProduct->quantity;

        $this->assertEquals($expectedEarnings, ClientStatistics::earnings($this->client->id));
        $this->assertEquals(floor($expectedMoneyUserHasToReceive), floor(ClientStatistics::moneyUserHasToReceive($this->client->id)));
        $this->assertEquals($expectedNumberOfProductsOrdered, ClientStatistics::totalNumberOfProductsOrdered($this->client->id));
        $this->assertEquals(floor($expectedDiscountReceived), floor(ClientStatistics::totalDiscountReceived($this->client->id)));
    }
}