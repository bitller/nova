<?php

use App\Bill;

/**
 * Test bills page
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillsTest extends TestCase {

    /**
     * Access bills page as a visitor
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
     * Make ajax request to get paginated bills
     */
    public function testBillsPagination() {

        $numberOfBills = 10;

        // Generate one user
        $user = factory(App\User::class)->create();

        // Generate one client
        $client = $user->clients()->save(factory(App\Client::class)->make());

        // Generate bills
        for ($i = 0; $i < $numberOfBills; $i++) {
            $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));
        }

        // Paginate results and compare with json response
        $pagination = Bill::select('bills.id', 'bills.campaign_number', 'bills.campaign_year', 'bills.payment_term', 'bills.other_details', 'clients.name as client_name')
            ->where('bills.user_id', $user->id)
            ->orderBy('bills.created_at', 'desc')
            ->join('clients', function($join) {
                $join->on('bills.client_id', '=', 'clients.id');
            })
            ->paginate(10);

        $this->actingAs($user)
            ->get('/bills/get')
            ->seeJson([
                'total' => $pagination->total(),
                'per_page' => $pagination->perPage(),
                'current_page' => $pagination->currentPage(),
                'last_page' => $pagination->lastPage(),
                'next_page_url' => $pagination->nextPageUrl(),
                'prev_page_url' => $pagination->previousPageUrl(),
            ]);
    }

    /**
     * Make ajax request to get paginated bills as a visitor
     */
    public function testBillsPaginationAsVisitor() {

        $this->visit('/bills/get')
            ->seePageIs('/login');

    }

    /**
     * Make ajax request to get paginated bills from page 3
     */
    public function testBillsPaginationFromThirdPage() {

        $numberOfBills = 45;

        // Generate one user
        $user = factory(App\User::class)->create();

        // Generate one client
        $client = $user->clients()->save(factory(App\Client::class)->make());

        // Generate bills
        for ($i = 0; $i < $numberOfBills; $i++) {
            $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));
        }

        $this->actingAs($user)
            ->visit('/bills/get?page=3')
            ->seeJson([
                'current_page' => 3
            ]);

    }

    /**
     * Access third bills page as a visitor
     */
    public function testBillsPaginationFromThirdPageAsVisitor() {

        $this->visit('/bills/get?page=3')
            ->seePageIs('/login');

    }

    /**
     * Create a new bill
     */
    public function testCreateBill() {

        $this->withoutMiddleware();

        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->post('/bills/create', ['client' => 'John Doe'])
            ->seeJson(['success' => true]);

    }

//    /**
//     * Create a new bill without client name
//     */
//    public function testCreateBillWithEmptyClient() {
//
//        $this->withoutMiddleware();
//
//        // Generate user
//        $user = factory(App\User::class)->create();
//
//        $this->actingAs($user)
//            ->post('/bills/create')
//            ->seeJson(['success' => true]);
//
//    }

    /**
     * Make ajax request to create bill as a visitor
     */
    public function testCreateBillAsVisitor() {

        $this->withoutMiddleware();

        $this->post('/bills/create', ['client' => 'Bau'])
            ->see('Forbidden');

    }

    /**
     * Test delete bill functionality
     */
    public function testDeleteBill() {

        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        $this->actingAs($user)
            ->get('/bills/' . $bill->id . '/delete')
            ->seeJson(['success' => true]);

    }

}