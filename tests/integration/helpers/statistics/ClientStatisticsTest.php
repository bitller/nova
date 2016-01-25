<?php
use App\Helpers\Statistics\ClientStatistics;

/**
 * Integration tests for ClientStatistics helper.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ClientStatisticsTest extends TestCase {

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
            'paid' => 1
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
        $expectedEarnings += ($this->billProduct->final_price * $this->billProduct->quantity);
        $expectedEarnings += ($this->secondBillProduct->final_price * $this->secondBillProduct->quantity);
        $expectedEarnings += ($this->billApplicationProduct->final_price * $this->billApplicationProduct->quantity);
        $expectedEarnings += ($this->secondBillApplicationProduct->final_price * $this->secondBillApplicationProduct->quantity);

        $this->assertEquals(floor($expectedEarnings), floor(ClientStatistics::earnings($this->client->id)));
    }

    /**
     * Test totalNumberOfProductsOrdered method works.
     */
    public function test_get_client_number_of_ordered_products() {

        $expected = $this->billProduct->quantity + $this->secondBillProduct->quantity;
        $expected += $this->billApplicationProduct->quantity + $this->secondBillApplicationProduct->quantity;

        $this->assertEquals($expected, ClientStatistics::totalNumberOfProductsOrdered($this->client->id));
    }
}