<?php

namespace App\Http\Controllers\AdminCenter\Subscriptions;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\CreateNewOfferRequest;
use App\Offer;

/**
 * Allow admin to create, edit and delete offers.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class OffersController extends BaseController {

    /**
     * Allow only admin.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin-center.subscriptions.offers');
    }

    /**
     * Paginate offers.
     *
     * @return mixed
     */
    public function get() {
        return Offer::paginate();
    }

    /**
     * Allow admin to create new offers.
     *
     * @param CreateNewOfferRequest $request
     */
    public function create(CreateNewOfferRequest $request) {

        // Create new paymill request
        $paymillRequest = new \Paymill\Request(env('PAYMILL_API_KEY'));

        $currency = 'EUR';
        $interval = '1 MONTH';

        // Create new offer
        $paymillOffer = new \Paymill\Models\Request\Offer();
        $paymillOffer->setAmount($request->get('offer_amount'))
            ->setCurrency($currency)
            ->setInterval($interval)
            ->setName($request->get('offer_name'));

        $response = $paymillRequest->create($paymillOffer);

        // Save in database
        $offer = new Offer();
        $offer->paymill_offer_id = $response->getId();
        $offer->name = $request->get('offer_name');
        $offer->amount = $request->get('offer_amount');
        $offer->interval = $interval;
        $offer->currency = $currency;

        // Check if a promo code was given
        if ($request->get('promo_code')) {
            $offer->promo_code = $request->get('promo_code');
        }

        // Check if this offer will be used on sign up
        if ($request->get('use_on_ign_up') === 'use') {
            $offer->use_on_sign_up = true;
        }

        // Check if offer status should changed
        if ($request->get('offer_status') === 'enable') {
            $offer->disabled = false;
        }

        $offer->save();

        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->setSuccessMessage(trans('offers.offer_created'));
        return response($ajaxResponse->get())->header('Content-Type', 'application/json');
    }
}