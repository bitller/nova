<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test create bill feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateBillTest extends TestCase {

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
     * @var array
     */
    private $postData = [];

    /**
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();

        // Generate user and client
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        // Build array with post data
        $this->postData = [
            'client' => $this->client->name,
            'use_current_campaign' => true
        ];
    }

    /**
     * User create new bill with existent client.
     */
    public function test_create_new_bill_with_existent_client_using_current_campaign() {

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'client_id' => $this->client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Helpers\Campaigns::current()->id,
                'campaign_order' => 1
            ]);
    }

    /**
     * User create new bill with existent client but does not use current campaign.
     */
    public function test_create_new_bill_with_existent_client_using_other_campaign() {

        unset($this->postData['use_current_campaign']);
        $this->postData['campaign_year'] = date('Y');
        $this->postData['campaign_number'] = rand(1, 17);

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'client_id' => $this->client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('year', $this->postData['campaign_year'])->where('number', $this->postData['campaign_number'])->first()->id,
                'campaign_order' => 1
            ]);
    }

    /**
     * User create new bill with not existent client and use current campaign.
     */
    public function test_create_bill_with_not_existent_client_using_current_campaign() {

        $this->postData['client'] = 'Nicola';

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'client_id' => \App\Client::where('user_id', $this->user->id)->where('name', $this->postData['client'])->first()->id,
                'campaign_id' => \App\Helpers\Campaigns::current()->id,
                'campaign_order' => 1
            ]);
    }

    /**
     * User create new bill with not existent client and does not use current campaign.
     */
    public function test_create_bill_with_not_existent_client_using_other_campaign() {

        $this->postData['client'] = 'Alex';
        unset($this->postData['use_current_campaign']);
        $this->postData['campaign_year'] = date('Y');
        $this->postData['campaign_number'] = rand(1, 17);

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'client_id' => \App\Client::where('user_id', $this->user->id)->where('name', $this->postData['client'])->first()->id,
                'campaign_id' => \App\Campaign::where('year', $this->postData['campaign_year'])->where('number', $this->postData['campaign_number'])->first()->id,
                'campaign_order' => 1
            ]);
    }

    /**
     * User create new bill with client name that is also used by another user.
     */
    public function test_create_bill_with_client_name_used_by_another_user_using_current_campaign() {

        $secondUser = factory(\App\User::class)->create();
        $clientOfSecondUser = factory(\App\Client::class)->create(['user_id' => $secondUser->id]);

        $this->postData['client'] = $clientOfSecondUser->name;

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'client_id' => \App\Client::where('user_id', $this->user->id)->where('name', $clientOfSecondUser->name)->first()->id,
                'campaign_id' => \App\Helpers\Campaigns::current()->id,
                'campaign_order' => 1
            ]);
    }

    /**
     * User create new bill with client name used by another user and does not use current campaign.
     */
    public function test_create_bill_with_client_name_used_by_another_user_using_other_campaign() {

        $secondUser = factory(\App\User::class)->create();
        $clientOfSecondUser = factory(\App\Client::class)->create(['user_id' => $secondUser->id]);

        $this->postData['client'] = $clientOfSecondUser->name;
        unset($this->postData['use_current_campaign']);
        $this->postData['campaign_year'] = date('Y');
        $this->postData['campaign_number'] = rand(1, 17);

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'client_id' => \App\Client::where('user_id', $this->user->id)->where('name', $this->postData['client'])->first()->id,
                'campaign_id' => \App\Campaign::where('year', $this->postData['campaign_year'])->where('number', $this->postData['campaign_number'])->first()->id,
                'campaign_order' => 1
            ]);
    }

    /**
     * User tries to create bill with missing client name.
     */
    public function test_create_bill_with_missing_client_name() {

        $this->actingAs($this->user)
            ->post('/bills/create')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.client')])
            ]);
    }

    /**
     * User tries to create bill with too short client name.
     */
    public function test_create_bill_with_too_short_client_name() {

        $this->actingAs($this->user)
            ->post('/bills/create', ['client' => 'Ma'])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.min.string', ['attribute' => trans('validation.attributes.client'), 'min' => 3])
            ])
            ->notSeeInDatabase('clients', [
                'user_id' => $this->user->id,
                'name' => 'Ma'
            ]);
    }

    /**
     * User tries to create bill with too long client name.
     */
    public function test_create_bill_with_too_long_client_name() {

        $this->actingAs($this->user)
            ->post('/bills/create', ['client' => str_repeat('Alex', 16)])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.max.string', ['attribute' => trans('validation.attributes.client'), 'max' => 60])
            ])
            ->notSeeInDatabase('clients', [
                'user_id' => $this->user->id,
                'name' => str_repeat('Alex', 16)
            ]);
    }

    /**
     * User tries to create bill only with client name.
     */
    public function test_create_bill_only_with_client_name_using_other_campaign() {

        unset($this->postData['use_current_campaign']);
        $this->postData['client'] = 'Alex';

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required_unless', [
                    'attribute' => trans('validation.attributes.campaign_year'),
                    'other' => trans('validation.attributes.use_current_campaign'),
                    'values' => 'true'
                ])
            ])
            ->notSeeInDatabase('clients', [
                'user_id' => $this->user->id,
                'name' => $this->postData['client']
            ]);
    }

    /**
     * User tries to create bill without campaign number and does not use current campaign.
     */
    public function test_create_bill_without_campaign_number_using_other_campaign() {

        unset($this->postData['use_current_campaign']);
        $this->postData['client'] = 'Aloha';
        $this->postData['campaign_year'] = date('Y');

        $this->actingAs($this->user)
            ->post('/bills/create', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required_unless', [
                    'attribute' => trans('validation.attributes.campaign_number'),
                    'other' => trans('validation.attributes.use_current_campaign'),
                    'values' => 'true'
                ])
            ])
            ->notSeeInDatabase('clients', [
                'user_id' => $this->user->id,
                'name' => $this->postData['client']
            ]);
    }

}