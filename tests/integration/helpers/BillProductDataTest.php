<?php
use App\Helpers\BillProductData;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for BillProductData helper.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillProductDataTest extends TestCase {

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
    private $applicationProduct = null;

    /**
     * @var null
     */
    private $billProduct = null;

    /**
     * @var null
     */
    private $billApplicationProduct = null;

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
            'client_id' => $this->client->id
        ]);

        // Generate product and application product
        $this->product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $this->applicationProduct = factory(\App\ApplicationProduct::class)->create();

        // Generate bill product and bill application product
        $this->billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $this->product->id
        ]);
        $this->billApplicationProduct = factory(\App\BillApplicationProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $this->applicationProduct->id
        ]);
    }

    /**
     * Make sure getPrice method works.
     */
    public function test_get_price() {
        $this->assertEquals($this->billProduct->price, BillProductData::getPrice($this->billProduct->id));
        $this->assertEquals($this->billApplicationProduct->price, BillProductData::getPrice($this->billApplicationProduct->id));
    }

    /**
     * Make sure getFinalPrice method works correctly.
     */
    public function test_get_final_price() {
        $this->assertEquals($this->billProduct->final_price, BillProductData::getFinalPrice($this->billProduct->id));
        $this->assertEquals($this->billApplicationProduct->final_price, BillProductData::getFinalPrice($this->billApplicationProduct->id));
    }

    /**
     * Make sure getPage method works.
     */
    public function test_get_page() {
        $this->assertEquals($this->billProduct->page, BillProductData::getPage($this->billProduct->id));
        $this->assertEquals($this->billApplicationProduct->page, BillProductData::getPage($this->billApplicationProduct->id));
    }

    /**
     * Make sure getQuantity method works.
     */
    public function test_get_quantity() {
        $this->assertEquals($this->billProduct->quantity, BillProductData::getQuantity($this->billProduct->id));
        $this->assertEquals($this->billApplicationProduct->quantity, BillProductData::getQuantity($this->billApplicationProduct->id));
    }

    /**
     * Make sure getDiscount method works.
     */
    public function test_get_discount() {
        $this->assertEquals($this->billProduct->discount, BillProductData::getDiscount($this->billProduct->id));
        $this->assertEquals($this->billApplicationProduct->discount, BillProductData::getDiscount($this->billApplicationProduct->id));
    }
}