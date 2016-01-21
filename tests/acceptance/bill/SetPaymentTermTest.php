<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test set payment term feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SetPaymentTermTest extends TestCase {

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
    private $billWithPaymentTerm = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        // Generate user
        $this->user = factory(\App\User::class)->create();
        // Generate client
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        // Generate bill without payment term
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'payment_term' => ''
        ]);
        // Generate bill with payment term
        $this->billWithPaymentTerm = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);
    }

    /**
     * User set payment term to a bill without.
     */
    public function test_user_set_payment_term_to_a_bill_without() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-payment-term', ['payment_term' => date('d-m-Y')])
            ->seeJson([
                'success' => true,
                'message' => trans('bill.payment_term_updated')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'payment_term' => date('Y-m-d')
            ]);
    }

    /**
     * User set payment term to a bill that already have one.
     */
    public function test_user_set_payment_term() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->billWithPaymentTerm->id . '/edit-payment-term', ['payment_term' => date('d-m-Y')])
            ->seeJson([
                'success' => true,
                'message' => trans('bill.payment_term_updated')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->billWithPaymentTerm->id,
                'user_id' => $this->user->id,
                'payment_term' => date('Y-m-d')
            ]);
    }

    /**
     * User tries to use date with invalid format as bill payment term.
     */
    public function test_user_set_payment_term_with_invalid_date_format() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-payment-term', ['payment_term' => date('m-d-Y')])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.date_format', ['attribute' => trans('validation.attributes.payment_term'), 'format' => 'd-m-Y'])
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'payment_term' => '0000-00-00'
            ]);
    }

    /**
     * User set bill payment term with empty data.
     */
    public function test_user_set_payment_term_with_empty_data() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->billWithPaymentTerm->id . '/edit-payment-term')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.payment_term')])
            ])
            ->seeInDatabase('bills', [
                'id' => $this->billWithPaymentTerm->id,
                'user_id' => $this->user->id,
                'payment_term' => $this->billWithPaymentTerm->payment_term
            ]);
    }

    /**
     * User tries to set payment term to bill that belongs to another user.
     */
    public function test_user_set_bill_payment_term_of_another_user() {

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/bills/' . $this->bill->id . '/edit-payment-term', ['payment_term' => date('d-m-Y')])
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ]);
    }

    /**
     * User tries to set payment term to not existent bill.
     */
    public function test_user_set_payment_term_to_not_existent_bill() {

        $this->actingAs($this->user)
            ->post('/bills/str' . rand() . '/edit-payment-term', ['payment_term' => date('d-m-Y')])
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ]);
    }
}