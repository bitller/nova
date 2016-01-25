<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test edit client phone number feature.
 *
 * @author Alexandru Bugarin <alxandru.bugarin@gmail.com>
 */
class EditClientPhoneNumberTest extends TestCase {

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

        $this->postData['client_phone_number'] = str_shuffle('0123456793');
    }

    /**
     * User edit client phone number.
     */
    public function test_user_edit_client_phone_number() {

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-phone', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_phone_updated')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'phone_number' => $this->postData['client_phone_number']
            ]);
    }

    /**
     * User tries to edit client phone number with not existent client id.
     */
    public function test_user_edit_client_phone_number_with_not_existent_client_id() {

        $this->actingAs($this->user)
            ->post('/clients/str' . rand() . '/edit-phone', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('clients.client_not_found')
            ]);
    }
}