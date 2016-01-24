<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test edit client name feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditClientNameTest extends TestCase {

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
        $this->postData['client_name'] = substr(str_shuffle('qwertyuiopasdfghjklzxcvbnm'), 0, rand(3, 60));
    }

    /**
     * User edit client name.
     */
    public function test_user_edit_client_name() {

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-name', $this->postData)
            ->seeJson([
                'success' => true,
                'message' => trans('clients.client_name_updated')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'name' => $this->postData['client_name']
            ]);
    }

    /**
     * User tries to edit client name with not existent client id.
     */
    public function test_user_edit_client_name_with_not_existent_client_id() {

        $this->actingAs($this->user)
            ->post('/clients/str' . rand() . '/edit-name', $this->postData)
            ->seeJson([
                'success' => false,
                'message' => trans('clients.client_not_found')
            ]);
    }

    /**
     * User tries to edit client name with empty post data.
     */
    public function test_user_edit_client_name_with_empty_data() {

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-name')
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_name' => trans('validation.required', ['attribute' => trans('validation.attributes.client_name')])
                ]
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'name' => $this->client->name
            ]);
    }

    /**
     * User tries to edit client name with too short new one.
     */
    public function test_user_edit_client_name_with_too_short_new_one() {

        $this->postData['client_name'] = 'ab';

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-name', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_name' => trans('validation.between.string', ['attribute' => trans('validation.attributes.client_name'), 'min' => 3, 'max' => 60])
                ]
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'name' => $this->client->name
            ]);
    }

    /**
     * User tries to edit client name with too long new one.
     */
    public function test_user_edit_client_name_with_too_long_new_one() {

        $this->postData['client_name'] = str_repeat('abcde', 13);

        $this->actingAs($this->user)
            ->post('/clients/' . $this->client->id . '/edit-name', $this->postData)
            ->seeJson([
                'success' => false,
                'errors' => [
                    'client_name' => trans('validation.between.string', ['attribute' => trans('validation.attributes.client_name'), 'min' => 3, 'max' => 60])
                ]
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $this->client->id,
                'name' => $this->client->name
            ]);
    }

}