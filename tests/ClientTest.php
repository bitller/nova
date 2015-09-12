<?php

/**
 * Test client page
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ClientTest extends TestCase {

    /**
     * Access client page
     */
    public function testClientPage() {

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->visit('/clients/' . $client->id)
            ->see($user->email);

    }

    /**
     * Access client page as visitor
     */
    public function testClientPageAsVisitor() {

        $this->visit('/clients/4')
            ->seePageIs('/login');

    }

    /**
     * Edit client name
     */
    public function testEditClientName() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-name', ['name' => 'Alex'])
            ->seeJson(['success' => true]);
    }

    /**
     * Edit client name with empty one
     */
    public function testEditClientNameWithEmptyValue() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-name')
            ->seeJson(['success' => false]);

    }

    /**
     * Edit client name with too long one
     */
    public function testEditClientNameWithTooLongValue() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-name', ['name' => str_repeat($client->name, 50)])
            ->seeJson(['success' => false]);

    }

    /**
     * Edit client name with too short one
     */
    public function testEditClientNameWithTooShortValue() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-name', ['name' => 'Ab'])
            ->seeJson(['success' => false]);

    }

    /**
     * Edit client phone number
     */
    public function testEditClientPhoneNumber() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-phone', ['phone' => '0725433317'])
            ->seeJson(['success' => true]);

    }

    /**
     * Edit client phone number with empty one
     */
    public function testEditClientPhoneNumberWithEmptyValue() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-phone')
            ->seeJson(['success' => false]);

    }

    /**
     * Edit client phone number with too short one
     */
    public function testEditClientPhoneNumberWithTooShortValue() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-phone', ['phone' => '072'])
            ->seeJson(['success' => false]);

    }

    /**
     * Edit client phone number with too long one
     */
    public function testEditClientPhoneNumberWithTooLongValue() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-phone', ['phone' => str_repeat('0725433317', 2)])
            ->seeJson(['success' => false]);

    }

    /**
     * Edit client phone number with invalid one
     */
    public function testEditClientPhoneNumberWithInvalidValue() {

        $this->withoutMiddleware();

        // Generate user and client
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());

        $this->actingAs($user)
            ->post('/clients/' . $client->id . '/edit-phone', ['phone' => str_shuffle('ddd2149dn11')])
            ->seeJson(['success' => false]);

    }

}