<?php
use App\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test create client feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateClientTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * @var null
     */
    private $user = null;

    /**
     * @var null
     */
    private $postData = null;

    /**
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();

        // Generate user
        $this->user = factory(\App\User::class)->create();

        // Generate client post data
        $client = factory(\App\Client::class)->make();
        $this->postData = [
            'client_name' => $client->name,
            'client_email' => $client->email,
            'client_phone_number' => $client->phone_number
        ];
    }

    /**
     * User create new client.
     */
    public function test_create_new_client() {

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_added')
            ])
            ->seeInDatabase('clients', [
                'email' => $this->postData['client_email'],
                'user_id' => $this->user->id,
                'name' => $this->postData['client_name'],
                'phone_number' => $this->postData['client_phone_number']
            ]);
    }

    /**
     * User tries to create new client with empty data.
     */
    public function test_create_new_client_with_empty_data() {

        $numberOfClientsBeforeRequest = Client::where('user_id', $this->user->id)->count();

        $this->actingAs($this->user)
            ->post('/clients/create')
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_name' => trans('validation.required', ['attribute' => trans('validation.attributes.client_name')])
                ]
            ]);

        $this->assertEquals($numberOfClientsBeforeRequest, Client::where('user_id', $this->user->id)->count());
    }

    /**
     * User tries to create new client with too short and too long name.
     */
    public function test_create_new_client_with_too_short_and_too_long_name() {

        // Create client with too short name
        $this->postData['client_name'] = 'aa';
        $numberOfClientsBeforeRequest = Client::where('user_id', $this->user->id)->count();

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_name' => trans('validation.between.string', ['attribute' => trans('validation.attributes.client_name'), 'min' => 3, 'max' => 60])
                ]
            ]);
        $this->assertEquals($numberOfClientsBeforeRequest, Client::where('user_id', $this->user->id)->count());

        // Now create client with too long name
        $this->postData['client_name'] = str_repeat('test tests', 7);
        $numberOfClientsBeforeRequest = Client::where('user_id', $this->user->id)->count();

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_name' => trans('validation.between.string', ['attribute' => trans('validation.attributes.client_name'), 'min' => 3, 'max' => 60])
                ]
            ]);
        $this->assertEquals($numberOfClientsBeforeRequest, Client::where('user_id', $this->user->id)->count());
    }

    /**
     * User create new client without email and phone number.
     */
    public function test_create_new_client_with_empty_email_and_phone_number() {

        unset($this->postData['client_email']);
        unset($this->postData['client_phone_number']);

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_added')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'name' => $this->postData['client_name'],
                'email' => null,
                'phone_number' => null
            ]);
    }

    /**
     * User tries to create new client with email that is already used by another client of same user.
     */
    public function test_create_new_client_with_email_used_by_another_client_of_same_user() {

        $client = factory(Client::class)->create(['user_id' => $this->user->id]);
        $this->postData['client_email'] = $client->email;

        $clientsBeforeRequest = Client::where('user_id', $this->user->id)->count();

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_email' => trans('validation.email_not_used_by_another_user_client')
                ]
            ]);

        $this->assertEquals($clientsBeforeRequest, Client::where('user_id', $this->user->id)->count());
    }

    /**
     * User create new client with email that is already used by the client of another user.
     */
    public function test_create_new_client_with_email_user_by_client_of_another_user() {

        $anotherUser = factory(\App\User::class)->create();
        $client = factory(Client::class)->create(['user_id' => $anotherUser->id]);

        $this->postData['client_email'] = $client->email;

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_added')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'email' => $this->postData['client_email']
            ])
            ->seeInDatabase('clients', [
                'user_id' => $anotherUser->id,
                'email' => $this->postData['client_email']
            ]);
    }

    /**
     * User tries to create new client with phone number that is already used by a client of the same user.
     */
    public function test_create_new_client_with_phone_number_used_by_another_client_of_same_user() {

        $client = factory(Client::class)->create(['user_id' => $this->user->id]);
        $this->postData['client_phone_number'] = $client->phone_number;

        $clientsBeforeRequest = Client::where('user_id', $this->user->id)->count();

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_phone_number' => trans('validation.phone_number_not_used_by_another_user_client')
                ]
            ]);

        $this->assertEquals($clientsBeforeRequest, Client::where('user_id', $this->user->id)->count());
    }

    /**
     * User tries to create new client with phone number used by another client of another user.
     */
    public function test_create_new_client_with_phone_number_used_by_another_client_of_another_user() {

        $anotherUser = factory(\App\User::class)->create();
        $client = factory(Client::class)->create(['user_id' => $anotherUser->id]);

        $this->postData['client_phone_number'] = $client->phone_number;

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_added')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'phone_number' => $this->postData['client_phone_number']
            ])
            ->seeInDatabase('clients', [
                'user_id' => $anotherUser->id,
                'phone_number' => $this->postData['client_phone_number']
            ]);
    }

    /**
     * User tries to create new client with invalid phone number.
     */
    public function test_create_new_client_with_invalid_phone_number() {

        $this->postData['client_phone_number'] = 'phone_nr14';

        $clientsBeforeRequest = Client::where('user_id', $this->user->id)->count();

        $this->actingAs($this->user)
            ->post('/clients/create', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_phone_number' => trans('validation.digits', ['attribute' => trans('validation.attributes.client_phone_number'), 'digits' => 10])
                ]
            ]);

        $this->assertEquals($clientsBeforeRequest, Client::where('user_id', $this->user->id)->count());
    }
}