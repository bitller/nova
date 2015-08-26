<?php

/**
 * BillsTest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillsTest extends TestCase {

//    use WithoutMiddleware;

    /**
     * Access bills page as a not logged in user
     */
    public function testBillsPageAsVisitor() {
        $this->visit('/bills')
            ->seePageIs('/login');
    }

    /**
     * Access bills page as a logged in user
     */
    public function testBillsPageAsLoggedInUser() {

        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/bills')
            ->see($user->email);

    }

    /**
     * Create a bill as a logged in user
     */
    public function testCreateBill() {

        $this->withoutMiddleware();

        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->post('/bills/create', ['client' => 'John Doe'])
            ->seeJsonEquals([
                'success' => true,
                'message' => trans('bills.bill_created')
            ]);

    }

//    /**
//     * Create a bill as visitor
//     */
//    public function testCreateBillAsVisitor() {
//
//        $this->withoutMiddleware();
//
//        $response = $this->call('POST', '/bills/create', ['client' => 'John Doe']);
//        $this->assertEquals(403, $response->status());
//
//    }

    /**
     * Delete a bill as logged in user
     */
    public function testDeleteBill() {

        $user = factory(App\User::class)->create();
        $client = factory(App\Client::class)->create(['user_id' => $user->id]);
        $bill = factory(App\Bill::class)->create([
            'client_id' => $client->id,
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->get('/bills/delete/'.$bill->id)
            ->seeJsonEquals([
                'success' => true,
                'title' => trans('common.success'),
                'message' => trans('bills.bill_deleted')
            ]);

    }

//    public function testDeleteBillAsVisitor() {
//
//        $user = factory(App\User::class)->create();
//        $client = factory(App\Client::class)->create(['user_id' => $user->id]);
//        $bill = factory(App\Bill::class)->create([
//            'client_id' => $client->id,
//            'user_id' => $user->id
//        ]);
//
//        $this->withoutMiddleware();
//
//        $response = $this->call('POST', '/bills/delete/'.$bill->id);
//        $this->assertEquals(405, $response->status());
//
//    }

}