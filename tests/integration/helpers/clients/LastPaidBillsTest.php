<?php
use App\Helpers\Clients;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test lastPaidBills method.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LastPaidBillsTest extends TestCase {

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
     * Test function works as expected with paid bills.
     */
    public function test_last_paid_bills() {

        $paidBills = factory(\App\Bill::class, 3)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'paid' => 1
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        foreach ($paidBills as $bill) {
            factory(\App\BillProduct::class)->create([
                'bill_id' => $bill->id,
                'product_id' => $product->id
            ]);
        }

        $unpaidBills = factory(\App\Bill::class, 4)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $this->assertEquals(3, count(\App\Helpers\Clients::lastPaidBills($this->client->id)));
    }

    /**
     * Test function works fine when there are no paid bills.
     */
    public function test_last_paid_bills_with_no_paid_bills() {
        $this->assertEquals(0, Clients::lastPaidBills($this->client->id));
    }
}