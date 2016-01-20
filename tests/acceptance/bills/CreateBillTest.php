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
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * User create new bill with existent client.
     */
    public function test_create_new_bill_with_existent_client() {

        $this->actingAs($this->user)
            ->post('/bills/create', ['client' => $this->client->name])
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'client_id' => $this->client->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * User create new bill with not existent client.
     */
    public function test_create_bill_with_not_existent_client() {

        $this->actingAs($this->user)
            ->post('/bills/create', ['client' => 'Alex'])
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'client_id' => \App\Client::where('user_id', $this->user->id)->where('name', 'Alex')->first()->id
            ]);
    }

    /**
     * User create new bill with client name that is also used by another user.
     */
    public function test_create_bill_with_client_name_used_by_another_user() {

        $secondUser = factory(\App\User::class)->create();
        $clientOfSecondUser = factory(\App\Client::class)->create(['user_id' => $secondUser->id]);

        $this->actingAs($this->user)
            ->post('/bills/create', ['client' => $clientOfSecondUser->name])
            ->seeJson([
                'success' => true,
                'message' => trans('bills.bill_created')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'client_id' => \App\Client::where('user_id', $this->user->id)->where('name', $clientOfSecondUser->name)->first()->id
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

}