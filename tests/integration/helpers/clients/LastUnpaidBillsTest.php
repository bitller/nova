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
        $this->client = factory(\App\Client::class)->create();
    }

    /**
     * Make sure method works as expected.
     */
    public function test_last_unpaid_bills() {

        factory(\App\Bill::class, 17)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->assertEquals(17, Clients::lastUnpaidBills($this->client->id));
    }

    /**
     * Make sure method works when there are no unpaid bills.
     */
    public function test_last_unpaid_bills_with_no_unpaid_bills() {
        $this->assertEquals(0, Clients::lastUnpaidBills($this->client->id));
    }
}