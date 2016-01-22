<?php
use App\Helpers\BillProductData;
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
     * @var array
     */
    private $postData = [];

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

        // Complete post data array
        $this->postData = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $this->product->code,
            'product_quantity' => rand(1, 99)
        ];
    }

    /**
     * User edit bill product quantity.
     */
    public function test_user_edit_bill_product_quantity() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.quantity_updated')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->postData['product_quantity'],
                'price' => BillProductData::getPrice($this->billProduct->id),
                'discount' => BillProductData::getDiscount($this->billProduct->id)
            ]);
    }

    /**
     * User edit bill application quantity.
     */
    public function test_user_edit_bill_application_product_quantity() {

        $data = [
            'product_id' => $this->applicationProduct->id,
            'bill_product_id' => $this->billApplicationProduct->id,
            'product_code' => $this->applicationProduct->code,
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity',  $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.quantity_updated')
            ])
            ->seeInDatabase('bill_application_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->applicationProduct->id,
                'page' => $this->billApplicationProduct->page,
                'quantity' => $data['product_quantity'],
                'price' => BillProductData::getPrice($this->billApplicationProduct->id),
                'discount' => BillProductData::getDiscount($this->billApplicationProduct->id)
            ])
            ->notSeeInDatabase('bill_application_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->applicationProduct->id,
                'price' => $this->applicationProduct->price,
                'final_price' => $this->applicationProduct->final_price
            ]);
    }

    /**
     * User edit bill product with not existent bill id.
     */
    public function test_user_edit_bill_product_quantity_with_not_existent_bill_id() {

        $this->actingAs($this->user)
            ->post('/bills/str' . rand() . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);
    }

    /**
     * User tries to edit bill product quantity of another user.
     */
    public function test_user_edit_bill_product_quantity_of_another_user() {

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill application product quantity with empty data.
     */
    public function test_user_edit_bill_product_quantity_with_empty_data() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_quantity')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with empty product id.
     */
    public function test_user_edit_bill_product_quantity_with_empty_product_id() {

        unset($this->postData['product_id']);

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with invalid product id format.
     */
    public function test_user_edit_bill_product_quantity_with_invalid_product_id() {

        $this->postData['product_id'] = 'not_num';

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with not existent product id format.
     */
    public function test_user_edit_bill_product_quantity_with_not_existent_product_id() {

        $this->postData['product_id'] = rand(1000, 9999);
        while(\App\Product::where('id', $this->postData['product_id'])->count()) {
            $this->postData['product_id'] = rand(1000, 9999);
        }

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('bill.product_not_found')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with empty bill product id.
     */
    public function test_user_edit_bill_product_quantity_with_empty_bill_product_id() {

        unset($this->postData['bill_product_id']);

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with not numeric product id.
     */
    public function test_user_edit_bill_product_quantity_with_not_numeric_bill_product_id() {

        $this->postData['bill_product_id'] = 'str' . rand();

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.bill_product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with empty product code.
     */
    public function test_user_edit_bill_product_quantity_with_empty_product_code() {

        unset($this->postData['product_code']);

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with invalid product code format.
     */
    public function test_user_edit_bill_product_quantity_with_invalid_product_code_format() {

        $this->postData['product_code'] = 'str2201';

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => 5])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with empty quantity.
     */
    public function test_user_edit_bill_product_quantity_with_empty_quantity() {

        unset($this->postData['product_quantity']);

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_quantity')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price,
                'discount' => $this->billProduct->discount
            ]);
    }

    /**
     * User tries to edit bill product quantity with not numeric quantity.
     */
    public function test_user_edit_bill_product_quantity_with_not_numeric_quantity() {

        $this->postData['product_quantity'] = 'not num';

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_quantity')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page,
                'quantity' => $this->billProduct->quantity,
                'price' => $this->billProduct->price
            ]);
    }

    /**
     * User tries to edit bill product quantity with too small and too big quantity.
     */
    public function test_user_edit_bill_product_quantity_with_too_big_and_too_small_quantity() {

        $this->postData['product_quantity'] = -1;

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.between.numeric', ['attribute' => trans('validation.attributes.product_quantity'), 'min' => 1, 'max' => 999])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'quantity' => $this->billProduct->quantity
            ]);

        // Try with too big product quantity
        $this->postData['product_quantity'] = 1000;
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-quantity', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.between.numeric', ['attribute' => trans('validation.attributes.product_quantity'), 'min' => 1, 'max' => 999])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'quantity' => $this->billProduct->quantity
            ]);
    }
}