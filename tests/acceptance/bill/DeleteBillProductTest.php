<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete bill product feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteBillProductTest extends TestCase {

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
     * User delete bill product.
     */
    public function test_user_delete_bill_product() {

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete/' . $this->product->id . '/' . $this->product->code . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => true,
                'message' => trans('common.product_deleted')
            ]);
    }

    /**
     * User delete bill application product.
     */
    public function test_user_delete_bill_application_product() {

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete/' . $this->product->id . '/' . $this->product->code . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => true,
                'message' => trans('common.product_deleted')
            ]);
    }

    /**
     * User tries to delete bill product with not existent bill id.
     */
    public function test_user_delete_bill_product_with_not_existent_bill_id() {

        $this->actingAs($this->user)
            ->get('/bills/str' . rand() . '/delete/' . $this->product->id . '/' . $this->product->code . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ]);
    }

    /**
     * User tries to delete bill product of another user.
     */
    public function test_user_delete_bill_product_of_another_user() {

        $this->actingAs(factory(\App\User::class)->create())
            ->get('/bills/' . $this->bill->id . '/delete/' . $this->product->id . '/' . $this->product->code . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
            ]);
    }

    /**
     * User tries to delete bill product with not existent product id.
     */
    public function test_user_delete_bill_product_with_not_existent_product_id() {

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete/str' . rand() . '/' . $this->product->code . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id
            ]);
    }

    /**
     * User tries to delete bill product with product id of another user.
     */
    public function test_user_delete_bill_product_with_product_id_of_another_user() {

        $user = factory(\App\User::class)->create();
        $client = factory(\App\Client::class)->create(['user_id' => $user->id]);
        $bill = factory(\App\Bill::class)->create([
            'user_id' => $user->id,
            'client_id' => $client->id
        ]);
        $product = factory(\App\Product::class)->create(['user_id' => $user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id
        ]);

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete/' . $product->id . '/' . $this->product->code . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id
            ]);
    }

    /**
     * User tries to delete bill product with not existent product code.
     */
    public function test_user_delete_bill_product_with_not_existent_product_code() {

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete/' . $this->product->id . '/str' . str_shuffle(13574) . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id
            ]);
    }

    /**
     * User tries to delete bill product with not existent bill product id.
     */
    public function test_user_delete_bill_product_with_not_existent_bill_product_id() {

        $this->actingAs($this->user)
            ->get('/bills/' . $this->bill->id . '/delete/' . $this->product->id . '/' . $this->product->code . '/st' . rand())
            ->seeJson([
                'success' => true,
                'message' => trans('common.product_deleted')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id
            ]);
    }

    /**
     * User tries to delete bill product with all parameters invalid.
     */
    public function test_user_delete_bill_product_with_all_parameters_invalid() {

        $expectedNumberOfBillProducts = \App\BillProduct::where('bill_id', $this->bill->id)->count() + \App\BillApplicationProduct::where('bill_id', $this->bill->id)->count();

        $this->actingAs($this->user)
            ->get('/bills/st' . rand() . '/delete/s' . rand() . '/s' . str_shuffle('19823') . '/st' . rand())
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ])
            ->assertEquals($expectedNumberOfBillProducts, \App\BillProduct::where('bill_id', $this->bill->id)->count() + \App\BillApplicationProduct::where('bill_id', $this->bill->id)->count());
    }

    /**
     * User tries to delete bill product with last three parameters of another user.
     */
    public function test_user_delete_bill_product_with_last_three_parameters_of_another_user() {

        $user = factory(\App\User::class)->create();
        $client = factory(\App\Client::class)->create(['user_id' => $user->id]);
        $bill = factory(\App\Bill::class)->create([
            'user_id' => $user->id,
            'client_id' => $client->id
        ]);

        $this->actingAs($user)
            ->get('/bills/' . $bill->id . '/delete/' . $this->product->id . '/' . $this->product->code . '/' . $this->billProduct->id)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id
            ]);
    }
}