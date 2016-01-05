<?php

use App\Offer;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for offer model.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class OfferTest extends TestCase {

    use DatabaseTransactions;

    /**
     * Test offers pagination.
     */
    public function test_it_paginate_offers() {

        // Generate three offers
        factory(App\Offer::class, 3)->create();

        // Generate paginate instance
        $offers = Offer::paginate();

        $this->assertEquals($offers->count(), 3);
    }

}