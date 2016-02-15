<?php
use App\Helpers\Clients;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test lastUnpaidBills method.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LastUnpaidBillsTest extends TestCase {

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

        // Generate user
        $this->user = factory(\App\User::class)->create();

        // Generate client
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * Make sure method works as expected.
     */
    public function test_last_unpaid_bills() {

        $unpaidBills = factory(\App\Bill::class, 17)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'paid' => 0
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        foreach ($unpaidBills as $bill) {
            factory(\App\BillProduct::class)->create([
                'bill_id' => $bill->id,
                'product_id' => $product->id
            ]);
        }

        $this->assertEquals(5, count(Clients::lastUnpaidBills($this->client->id)));
    }

    /**
     * Make sure method works when there are no unpaid bills.
     */
    public function test_last_unpaid_bills_with_no_unpaid_bills() {
        $this->assertEquals(0, Clients::lastUnpaidBills($this->client->id));
    }
}