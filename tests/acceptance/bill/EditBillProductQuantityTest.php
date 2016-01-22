<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test edit bill product quantity feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditBillProductQuantityTest extends TestCase {

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
     * User edit bill product quantity.
     */
    public function test_user_edit_bill_product_quantity() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $this->product->code,
            'quantity' => rand(1, 99)
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.quantity_updated')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'quantity' => $data['quantity']
            ]);
    }
}