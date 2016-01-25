<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Authorize and validate EditClientEmailTest.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditClientEmailTest extends TestCase {

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

        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        $this->postData['client_email'] = factory(\App\User::class)->make()->email;
    }

    /**
     * User edit client email.
     */
    public function test_user_edit_client_email() {

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-email', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_email_updated')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'email' => $this->postData['client_email']
            ]);
    }

    /**
     * User tries to edit client email with not existent client id.
     */
    public function test_user_edit_client_email_with_not_existent_client_id() {

        $this->actingAs($this->user)
            ->post('/clients/str' . rand() . '/edit-email',  $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('clients.client_not_found')
            ]);
    }

    /**
     * User tries to edit client email with client id of another user.
     */
    public function test_user_edit_client_email_with_client_id_of_another_user() {

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/clients/' . $this->client->id . '/edit-email', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('clients.client_not_found')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'email' => $this->client->email
            ]);
    }

    /**
     * User edit client email with empty post data.
     */
    public function test_user_edit_client_email_with_empty_data() {

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-email')
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_email_updated')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'email' => null
            ]);
    }

    /**
     * User tries to edit client email with email used by another client of same user.
     */
    public function test_user_edit_client_email_with_email_used_by_another_client_of_same_user() {

        $anotherClient = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        $this->postData['client_email'] = $anotherClient->email;

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-email', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_email' => trans('validation.email_not_used_by_another_user_client')
                ]
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'email' => $this->client->email
            ]);
    }

    /**
     * User edit client email with email used by another client of another user.
     */
    public function test_user_edit_client_email_with_email_used_by_another_client_of_other_user() {

        $anotherUser = factory(\App\User::class)->create();
        $this->postData['client_email'] = factory(\App\Client::class)->create(['user_id' => $anotherUser->id])->email;

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-email', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_email_updated')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'email' => $this->postData['client_email']
            ]);
    }

    /**
     * User tries to edit client email with invalid email format.
     */
    public function test_user_edit_client_email_with_invalid_email() {

        $this->postData['client_email'] = 'wring_format_email';

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-email', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_email' => trans('validation.email', ['attribute' => trans('validation.attributes.client_email')])
                ]
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'email' => $this->client->email
            ]);
    }

}