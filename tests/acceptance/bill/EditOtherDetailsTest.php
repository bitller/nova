<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test edit other details feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditOtherDetailsTest extends TestCase {

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
    private $simpleBill = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'other_details' => str_repeat('random string', rand(5, 10))
        ]);
        $this->simpleBill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'other_details' => ''
        ]);
    }

    /**
     * User add other details.
     */
    public function test_user_add_other_details() {

        $data = [
            'other_details' => str_repeat('Here will be added bill other details', rand(5,10))
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->simpleBill->id . '/edit-other-details', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.other_details_updated')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->simpleBill->id,
                'user_id' => $this->user->id,
                'other_details' => $data['other_details']
            ]);
    }

    /**
     * User edit bill other details.
     */
    public function test_user_edit_other_details() {

        $data = [
            'other_details' => str_repeat('other details goes here', rand(4, 10))
        ];

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-other-details', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.other_details_updated')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'other_details' => $data['other_details']
            ]);
    }

    /**
     * User add bill other details with empty data.
     */
    public function test_user_add_other_details_with_empty_data() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->simpleBill->id . '/edit-other-details')
            ->seeJson([
                'success' => true,
                'message' => trans('bill.other_details_updated')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->simpleBill->id,
                'user_id' => $this->user->id,
                'other_details' => ''
            ]);
    }

    /**
     * User edit bill other details with empty data.
     */
    public function test_user_edit_other_details_with_empty_data() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-other-details')
            ->seeJson([
                'success' => true,
                'message' => trans('bill.other_details_updated')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'other_details' => ''
            ]);
    }

    /**
     * User add bill other details with too long data.
     */
    public function test_user_add_other_details_with_too_long_data() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->simpleBill->id . '/edit-other-details', ['other_details' => str_repeat('this string is too long', 200)])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.max.string', ['attribute' => trans('validation.attributes.other_details'), 'max' => 2000])
            ])
            ->seeInDatabase('bills', [
                'id' => $this->simpleBill->id,
                'user_id' => $this->user->id,
                'other_details' => ''
            ]);
    }

    /**
     * User edit bill other details with too long data.
     */
    public function test_user_edit_other_details_with_too_long_data() {

        $this->actingAs($this->user)
            ->post('/bills/' . $this->bill->id . '/edit-other-details', ['other_details' => str_repeat('this string is too long', 200)])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.max.string', ['attribute' => trans('validation.attributes.other_details'), 'max' => 2000])
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'other_details' => $this->bill->other_details
            ]);
    }

    /**
     * User tries to edit other details of another user.
     */
    public function test_user_edit_other_details_of_another_user() {

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/bills/' . $this->bill->id . '/edit-other-details', ['other_details' => 'other details'])
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ])
            ->seeInDatabase('bills', [
                'id' => $this->bill->id,
                'user_id' => $this->user->id,
                'other_details' => $this->bill->other_details
            ]);
    }

    /**
     * User tries to edit other details of not existent bill.
     */
    public function test_user_edit_other_details_of_not_existent_bill() {

        $this->actingAs($this->user)
            ->post('/bills/str' . rand() . '/edit-other-details', ['other_details' => 'other details'])
            ->seeJson([
                'success' => false,
                'message' => trans('bill.bill_not_found')
            ]);
    }
}