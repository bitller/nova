<?php

namespace App\Http\Controllers\AdminCenter\Subscriptions;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\CreateNewOfferRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\DeleteOfferRequest;
use App\Offer;
use Paymill\Models\Response\Subscription;

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

        $offer = Offer::create([
            'paymill_offer_id' => $response->getId(),
            'name' => $request->get('offer_name'),
            'amount' => $request->get('offer_amount'),
            'interval' => $interval,
            'currency' => $currency,
            'promo_code' => $request->get('promo_code'),
            'use_on_sign_up' => $request->get('use_on_sign_up'),
            'disabled' => !$request->get('enable_offer')
        ]);

        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->setSuccessMessage(trans('offers.offer_created'));
        return response($ajaxResponse->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete offer.
     *
     * @param DeleteOfferRequest $request
     * @return mixed
     */
    public function deleteOffer(DeleteOfferRequest $request) {

        // Find offer
        $offer = Offer::find($request->get('offer_id'));

        // Delete all subscriptions that belongs to this offer
        Subscription::where('offer_id', $offer->id)->delete();

        // Delete offer
        $offer->delete();

        // Return success response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('offers.offer_deleted'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

}