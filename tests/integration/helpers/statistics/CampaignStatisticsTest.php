<?php
use App\Helpers\Statistics\CampaignStatistics;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test CampaignStatistics helper.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CampaignStatisticsTest extends TestCase {

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
    private $secondClient = null;

    /**
     * @var null
     */
    private $bill = null;

    /**
     * @var null
     */
    private $secondBill = null;

    /**
     * @var null
     */
    private $campaign = null;

    /**
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();
        // Generate user, client and bill with current campaign
        $this->user = factory(App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        // Generate another client with another bill that does not use current campaign
        $this->secondClient = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        $this->secondBill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->secondClient->id,
        ]);

        // Set current campaign used in bills
        $this->campaign = \App\Helpers\Campaigns::current();
    }

    /**
     * Test total bills price returned when all bills are empty.
     */
    public function test_total_bills_price_with_all_bills_empty() {
        $this->actingAs($this->user)
            ->assertEquals(0, CampaignStatistics::totalBillsPrice($this->campaign->number, $this->campaign->year));
    }

    /**
     * Test totalBillsPrice method.
     */
    public function test_total_bills_price() {

        // Add one product to first bill
        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $product->id
        ]);

        // Add two products to the second bill
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();
        $secondProduct = factory(\App\Product::class)->create([
            'user_id' => $this->user->id
        ]);

        $billApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $applicationProduct->id
        ]);

        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $secondProduct->id
        ]);

        // Calculate the expected total bills price
        $expectedTotalBillsPrice = $billProduct->final_price + $billApplicationProduct->final_price + $secondBillProduct->final_price;

        $this->actingAs($this->user)
            ->assertEquals($expectedTotalBillsPrice, CampaignStatistics::totalBillsPrice($this->campaign->number, $this->campaign->year));
    }

    /**
     * Test numberOfClients methods works as expected.
     */
    public function test_number_of_clients() {

        $this->actingAs($this->user)
            ->assertEquals(2, CampaignStatistics::numberOfClients($this->campaign->number, $this->campaign->year));
    }

    /**
     * Test numberOfBills method works.
     */
    public function test_number_of_bills() {

        $this->actingAs($this->user)
            ->assertEquals(2, CampaignStatistics::numberOfBills($this->campaign->number, $this->campaign->year));
    }

    /**
     * Make sure totalDiscount methods works correctly.
     */
    public function test_total_discount() {

        // Create one product and add to the first bill
        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $product->id
        ]);

        // Create one application product and add to the first bill
        $applicationProduct = factory(\App\ApplicationProduct::class)->create();
        $billApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $applicationProduct->id
        ]);

        // Create another product and add to the second bill
        $secondProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $secondProduct->id
        ]);

        // Create also another application product and add to the second bill
        $secondApplicationProduct = factory(\App\ApplicationProduct::class)->create();
        $secondBillApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $secondApplicationProduct->id
        ]);

        // Calculate expected discount
        $expectedDiscount = ($billProduct->price - $billProduct->final_price) + ($billApplicationProduct->price - $billApplicationProduct->final_price);
        $expectedDiscount += ($secondBillProduct->price - $secondBillProduct->final_price) + ($secondBillApplicationProduct->price - $secondBillApplicationProduct->final_price);
        $expectedDiscount = number_format($expectedDiscount, 2);

        $this->actingAs($this->user)
            ->assertEquals($expectedDiscount, CampaignStatistics::totalDiscount($this->campaign->number, $this->campaign->year));
    }

    /**
     * Test numberOfProducts methods works as expected with all bills empty.
     */
    public function test_number_of_products_when_all_bills_are_empty() {

        $this->actingAs($this->user)
            ->assertEquals(0, CampaignStatistics::numberOfProducts($this->campaign->number, $this->campaign->year));
    }

    /**
     * Test numberOfProducts works as expected.
     */
    public function test_number_of_products() {

        // Generate one product and add to first bill
        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $product->id
        ]);

        // Generate another product and add to second bill
        $secondProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->secondBill->id,
            'product_id' => $secondProduct->id
        ]);

        // Calculate expected number of products
        $expectedNumberOfProducts = $billProduct->quantity + $secondBillProduct->quantity;

        $this->actingAs($this->user)
            ->assertEquals($expectedNumberOfProducts, CampaignStatistics::numberOfProducts($this->campaign->number, $this->campaign->year));
    }

    /**
     * Make sure numberOfCashedBills works as expected.
     */
    public function test_number_of_cashed_bills() {

        factory(\App\Bill::class, 2)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'paid' => 1
        ]);

        factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->secondClient->id,
            'paid' => 1
        ]);

        $this->actingAs($this->user)
            ->assertEquals(3, CampaignStatistics::numberOfCashedBills($this->campaign->number, $this->campaign->year));
    }

    /**
     * Make sure cashedMoney function works as expected.
     */
    public function test_cashed_money() {

        $cashedBill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'paid' => 1
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $cashedBill->id,
            'product_id' => $product->id
        ]);

        // Create another cashed bill
        $secondCashedBill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'paid' => 1
        ]);

        // Generate and add product also to this bill
        $secondProduct = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $secondCashedBill->id,
            'product_id' => $secondProduct->id
        ]);

        // Calculate expected cashed money
        $expectedCashedMoney = $billProduct->final_price + $secondBillProduct->final_price;

        $this->actingAs($this->user)
            ->assertEquals($expectedCashedMoney, CampaignStatistics::cashedMoney($this->campaign->number, $this->campaign->year));
    }

    /**
     * Make sure numberOfBillsWithPassedPaymentTerm method works.
     */
    public function test_number_of_bills_with_passed_payment_term() {

        $bill = factory(\App\Bill::class)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'payment_term' => date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 year'))
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id
        ]);

        $this->actingAs($this->user)
            ->assertEquals(1, CampaignStatistics::numberOfBillsWithPassedPaymentTerm($this->campaign->number, $this->campaign->year));
    }
}