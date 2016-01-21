<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test edit bill product page feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditBillProductPageTest extends TestCase {

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

        // Generate user and client
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        // Generate bill
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        // Generate one product and one application product
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
     * User edit bill product page.
     */
    public function test_user_edit_bill_product_page() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $this->product->code,
            'product_page' => rand(1, 99)
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.page_updated')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $data['product_page']
            ]);
    }

    /**
     * User edit bill application page.
     */
    public function test_user_edit_bill_application_product_page() {

        $data = [
            'product_id' => $this->applicationProduct->id,
            'bill_product_id' => $this->billApplicationProduct->id,
            'product_code' => $this->applicationProduct->code,
            'product_page' => rand(1, 99)
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.page_updated')
            ])
            ->seeInDatabase('bill_application_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->applicationProduct->id,
                'page' => $data['product_page']
            ]);
    }

    /**
     * User tries to edit bill product page with empty data.
     */
    public function test_user_edit_bill_product_page_with_empty_data() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_page')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit bill product page with empty, numeric and not existent product id.
     */
    public function test_user_edit_bill_product_page_with_empty_then_with_not_numeric_product_id() {

        $data = [
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $this->product->code,
            'product_page' => rand(1, 99)
        ];

        // Make request wit empty product id
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);

        // Make request with not numeric product id
        $data['product_id'] = 'str' . $this->product->id;

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);

        // Make request with not existent product id
        $data['product_id'] = rand(999, 9999);
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('bill.product_not_found')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit bill product page with empty then not numeric and then not existent bill product id.
     */
    public function test_user_edit_bill_product_page_with_empty_then_with_not_numeric_and_then_with_not_existent_bill_product_id() {

        $data = [
            'product_id' => $this->product->id,
            'product_code' => $this->product->code,
            'product_page' => rand(1, 99)
        ];

        // Make request with empty bill product id
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);

        // Make request with not numeric bill product id
        $data['bill_product_id'] = 'str' . $this->billProduct->id;

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.bill_product_id')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);

        // Make request with not existent bill product id
        $data['bill_product_id'] = rand(100, 999);
        while(\App\BillProduct::where('id', $data['bill_product_id'])->count()) {
            $data['bill_product_id'] = rand(100, 999);
        }

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_product_not_found')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit bill product page with empty product code.
     */
    public function test_user_edit_bill_product_page_with_empty_product_code() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_page' => rand(1, 99)
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit product page with too short, too long and invalid product code.
     */
    public function test_user_edit_bill_product_page_with_too_short_too_long_and_invalid_product_code() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => '1234',
            'product_page' => rand(1, 99)
        ];

        // Make request with too short product code
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => 5])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);

        // Make request with too long product code
        $data['product_code'] = '1234567';
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => 5])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);

        // Make request with invalid product code
        $data['product_code'] = 'string122';
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => 5])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit bill product page with not existent product code.
     */
    public function test_user_edit_bill_product_page_with_not_existent_product_code() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => substr(str_shuffle('123456789'), 0, 5),
            'product_page' => rand(1, 99)
        ];

        while (\App\Product::where('user_id', $this->user->id)->where('code', $data['product_code'])->count()) {
            $data['product_code'] = substr(str_shuffle('123456789'), 0, 5);
        }

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit bill product page with product code of another user.
     */
    public function test_user_edit_bill_product_page_with_product_code_of_another_user() {

        // Generate another user data
        $anotherUser = factory(\App\User::class)->create();
        $client = factory(\App\Client::class)->create(['user_id' => $anotherUser->id]);
        $bill = factory(\App\Bill::class)->create([
            'user_id' => $anotherUser->id,
            'client_id' => $client->id
        ]);
        $product = factory(\App\Product::class)->create(['user_id' => $anotherUser->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id
        ]);

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $product->code,
            'product_page' => rand(1, 99)
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);
    }

    /**
     * User tries to edit bill product page with empty product page.
     */
    public function test_user_edit_bill_product_page_with_empty_product_page() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $this->product->code,
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_page')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit bill product page with product page in not numeric format.
     */
    public function test_user_edit_bill_product_page_with_invalid_product_page() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $this->product->code,
            'product_page' => 'notnumeric'
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_page')])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }

    /**
     * User tries to edit bill product page with too long and too short product page.
     */
    public function test_user_edit_bill_product_page_with_too_short_and_too_long_product_page() {

        $data = [
            'product_id' => $this->product->id,
            'bill_product_id' => $this->billProduct->id,
            'product_code' => $this->product->code,
            'product_page' =>  -1
        ];

        // Try with too short
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.between.numeric', ['attribute' => trans('validation.attributes.product_page'), 'max' => 2000, 'min' => 1])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);

        // Try with too long
        $data['product_page'] = 2002;
        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-page', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.between.numeric', ['attribute' => trans('validation.attributes.product_page'), 'max' => 2000, 'min' => 1])
            ])
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id,
                'product_id' => $this->product->id,
                'page' => $this->billProduct->page
            ]);
    }
}