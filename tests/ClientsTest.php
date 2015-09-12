<?php

/**
 * Test clients page
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ClientsTest extends TestCase {

    /**
     * Access clients page as visitor.
     */
    public function testClientsPageAsVisitor() {

        $this->visit('/clients')
            ->seePageIs('/login');

    }

    /**
     * Access clients page as logged in user.
     */
    public function testClientsPageAsLoggedInUser() {

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/clients')
            ->see($user->email);

    }

    /**
     * Make get request to get first page of clients.
     */
    public function testClientsPagination() {

        // Number of clients to generate
        $numberOfClients = 45;

        // Generate one user
        $user = factory(App\User::class)->create();

        // Generate clients
        for ($i = 0; $i < $numberOfClients; $i++) {
            $user->clients()->save(factory(App\Client::class)->make());
        }

        // Get expected results
        $pagination = \App\Client::where('user_id', $user->id)->orderby('created_at', 'desc')->paginate(10);

        $this->actingAs($user)
            ->get('/clients/get')
            ->seeJson([
                'total' => $pagination->total(),
                'per_page' => $pagination->perPage(),
                'current_page' => $pagination->currentPage(),
            ]);

    }

    /**
     * Make get request to get first page of clients as visitor.
     */
    public function testClientsPaginationAsVisitor() {

        $this->visit('/clients/get')
            ->seePageIs('/login');

    }

    /**
     * Make get request to get third page of clients.
     */
    public function testClientsPaginationFromThirdPage() {

        // Number of clients to generate and page to make request
        $numberOfClients = 45;
        $page = 3;

        // Generate user
        $user = factory(App\User::class)->create();

        // Generate clients
        for ($i = 0; $i < $numberOfClients; $i++) {
            $user->clients()->save(factory(App\Client::class)->make());
        }

        $this->actingAs($user)
            ->get('/clients/get?page=' . $page)
            ->seeJson([
                'current_page' => $page
            ]);

    }

    /**
     * Make get request to get third page of clients as a visitor.
     */
    public function testClientsPaginationFromThirdPageAsVisitor() {

        $page = 3;

        $this->visit('/clients/get?page=' . $page)
            ->seePageIs('/login');

    }

    /**
     * Make post request to create a new client with all fields completed correctly.
     */
    public function testCreateClient() {

        $this->withoutMiddleware();

        // Generate one user and one client
        $user = factory(App\User::class)->create();
        $client = factory(App\Client::class)->make(['phone_number' => '0725433317']);

        $this->actingAs($user)
            ->post('/clients/create', ['name' => $client->name, 'phone' => $client->phone_number])
            ->seeJson(['success' => true]);

    }

    /**
     * Try to create a new client as a visitor
     */
    public function testCreateClientAsVisitor() {

        $this->withoutMiddleware();

        // Generate client
        $client = factory(App\Client::class)->make();

        $this->post('/clients/create', ['name' => $client->name, 'phone' => $client->phone_number])
            ->seeJson(['success' => false]);

    }

    /**
     * Make post request to create a new client without phone number field.
     */
    public function testCreateClientWithoutPhoneNumber() {

        $this->withoutMiddleware();

        // Generate one user and one client
        $user = factory(App\User::class)->create();
        $client = factory(App\Client::class)->make();

        $this->actingAs($user)
            ->post('/clients/create', ['name' => $client->name])
            ->seeJson(['success' => true]);

    }

    /**
     * Make post request to create a new client without name field.
     */
    public function testCreateClientWithoutName() {

        $this->withoutMiddleware();

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->post('/clients/create', ['phone' => '0725433317'])
            ->seeJson(['success' => false]);

    }

    /**
     * Try to create a client with a too short name
     */
    public function testCreateClientWithTooShortName() {

        $this->withoutMiddleware();

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->post('/clients/create', ['name' => 'ab'])
            ->seeJson(['success' => false]);

    }

    /**
     * Try to create a client with a too long name
     */
    public function testCreateClientWithTooLongName() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = factory(App\Client::class)->make();

        // Make client name long
        $client->name = str_repeat($client->name, 50);

        $this->actingAs($user)
            ->post('/clients/create', ['name' => $client->name])
            ->seeJson(['success' => false]);

    }

    /**
     * Try to create a client with too long phone number
     */
    public function testCreateClientWithTooLongPhoneNumber() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = factory(App\Client::class)->make(['phone_number' => '07254333171717']);

        $this->actingAs($user)
            ->post('/clients/create', ['name' => $client->name, 'phone' => $client->phone_number])
            ->seeJson(['success' => false]);

    }

    /**
     * Try to create a client with too short phone number
     */
    public function testCreateClientWithTooShortPhoneNumber() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = factory(App\Client::class)->make(['phone_number' => '07254333']);

        $this->actingAs($user)
            ->post('/clients/create', ['name' => $client->name, 'phone' => $client->phone_number])
            ->seeJson(['success' => false]);

    }

    /**
     * Create a client with invalid phone number
     */
    public function testCreateClientWithInvalidPhoneNumber() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = factory(App\Client::class)->make(['phone_number' => '09asdas021']);

        $this->actingAs($user)
            ->post('/clients/create', ['name' => $client->name, 'phone' => $client->phone_number])
            ->seeJson(['success' => false]);

    }

    /**
     * Make post request to create a new client with all fields empty.
     */
    public function testCreateClientWithEmptyFields() {

        $this->withoutMiddleware();

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->post('/clients/create')
            ->seeJson(['success' => false]);

    }

    /**
     * Make get request to delete a client.
     */
    public function testDeleteClient() {

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->get('/clients/' . $client->id . '/delete')
            ->seeJson(['success' => true]);

    }

    /**
     * Make get request to delete a client that does not exists.
     */
    public function testDeleteNotExistentClient() {

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->get('/clients/' . rand(1,999) . '/delete')
            ->seeJson(['success' => false]);

    }

    /**
     * Make a get request to delete a client with an invalid id format
     */
    public function testDeleteClientWithInvalidId() {

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->get('/clients/' . str_shuffle('ab12') . '/delete')
            ->seeJson(['success' => false]);

    }

}