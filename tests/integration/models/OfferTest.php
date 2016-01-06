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

    /**
     * Test creation of new offer.
     */
    public function test_it_create_new_offer() {

        // Generate new offer
        $generatedOffer = factory(App\Offer::class)->make();

        // Insert in database
        $offer = Offer::create([
            'paymill_offer_id' => $generatedOffer->paymill_offer_id,
            'name' => $generatedOffer->name,
            'amount' => $generatedOffer->amount,
            'currency' => $generatedOffer->currency,
            'interval' => $generatedOffer->interval
        ]);

        // Check if offer exists in database
        $this->seeInDatabase('offers', [
            'paymill_offer_id' => $offer->paymill_offer_id,
            'name' => $offer->name,
            'amount' => $offer->amount,
            'interval' => $offer->interval,
            'currency' => $offer->currency
        ]);
    }

    /**
     * Test it edit offer name.
     */
    public function test_it_edit_offer_name() {

        // Generate new offer
        $generatedOffer = factory(App\Offer::class)->create();

        // Edit offer name
        $offer = Offer::find($generatedOffer->id);
        $offer->name = 'new name';
        $offer->save();

        // Check if the offer name was updated
        $this->seeInDatabase('offers', [
            'id' => $offer->id,
            'paymill_offer_id' => $offer->paymill_offer_id,
            'name' => 'new name'
        ]);
    }

    /**
     * Check if edit of offer amount works.
     */
    public function test_it_edit_offer_amount() {

        // Generate new offer
        $generatedOffer = factory(App\Offer::class)->create();

        // Edit offer amount
        $offer = Offer::find($generatedOffer->id);
        $offer->amount = 1997;
        $offer->save();

        // Check if offer amount was updated
        $this->seeInDatabase('offers', [
            'id' => $offer->id,
            'paymill_offer_id' => $offer->paymill_offer_id,
            'amount' => 1997
        ]);
    }

    /**
     * Check if edit of offer promo code works.
     */
    public function test_it_edit_offer_promo_code() {

        // Generate new offer
        $generatedOffer = factory(App\Offer::class)->create();

        // Edit offer promo code
        $offer = Offer::find($generatedOffer->id);
        $offer->promo_code = 'Christmas2015';
        $offer->save();

        // Check if offer promo code was updated
        $this->seeInDatabase('offers', [
            'id' => $offer->id,
            'paymill_offer_id' => $offer->paymill_offer_id,
            'promo_code' => 'Christmas2015'
        ]);
    }

    /**
     * Check if an offer can be used on sign up.
     */
    public function test_it_use_as_sign_up_offer() {

        // Generate new offer
        $generatedOffer = factory(App\Offer::class)->create();

        // First, remove current offer that is used on sign up
        Offer::where('use_on_sign_up', true)->update(['use_on_sign_up' => false]);

        // Set new offer to be used on sign up
        $offer = Offer::find($generatedOffer->id);
        $offer->use_on_sign_up = true;
        $offer->save();

        // Check if offer is now used on sign up
        $this->seeInDatabase('offers', [
            'id' => $offer->id,
            'paymill_offer_id' => $offer->paymill_offer_id,
            'use_on_sign_up' => true
        ]);
    }

    /**
     * Remove current offer used on sign up.
     */
    public function test_it_remove_as_sign_up_offer() {

        // Generate new offer
        $generatedOffer = factory(App\Offer::class)->create(['use_on_sign_up' => true]);

        // Remove as sign up offer
        $offer = Offer::find($generatedOffer->id);
        $offer->use_on_sign_up = false;
        $offer->save();

        // Check if offer is no more used on sign up
        $this->seeInDatabase('offers', [
            'id' => $offer->id,
            'paymill_offer_id' => $offer->paymill_offer_id,
            'use_on_sign_up' => false
        ]);

        // Make sure no other offer is used on sign up
        $this->assertEquals(0, Offer::where('use_on_sign_up')->count());
    }

    /**
     * Test if enable offer works.
     */
    public function test_it_enable_offer() {

        // Generate new offer
        $generatedOffer = factory(App\Offer::class)->create();

        $offer = Offer::find($generatedOffer->id);
        $offer->disabled = false;
        $offer->save();

        // Check in database if offer is enabled
        $this->seeInDatabase('offers', [
            'id' => $offer->id,
            'paymill_offer_id' => $offer->paymill_offer_id,
            'disabled' => false
        ]);
    }

    /**
     * Test if disable offer works.
     */
    public function test_it_disable_offer() {

        // Generate enabled offer
        $generatedOffer = factory(App\Offer::class)->create(['disabled' => false]);

        $offer = Offer::find($generatedOffer->id);
        $offer->disabled = true;
        $offer->save();

        // Check in database in offer is disabled
        $this->seeInDatabase('offers', [
            'id' => $offer->id,
            'paymill_offer_id' => $offer->paymill_offer_id,
            'disabled' => true
        ]);
    }

    /**
     * Test deletion of an offer.
     */
    public function test_it_delete_offer() {

        // Generate new offer
        $offer = factory(App\Offer::class)->create();

        // Make sure offer was inserted
        $this->seeInDatabase('offers', [
            'id' => $offer->id
        ]);

        // Delete offer from database
        Offer::find($offer->id)->delete();

        // Check if offer was deleted
        $this->notSeeInDatabase('offers', [
            'id' => $offer->id
        ]);
    }

    public function test_it_delete_all_offers() {
        //
    }

}