<?php

namespace App\Http\Controllers\AdminCenter\Subscriptions;

use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\CreateNewOfferRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\DeleteOfferRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\DisableOfferRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\EditOfferAmountRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\EditOfferNameRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\EditOfferPromoCodeRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\EnableOfferRequest;
use App\Http\Requests\AdminCenter\Subscriptions\Offers\UseOfferOnSignUpRequest;
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
        return Offer::countAssociatedSubscriptions()->paginate();
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
        Offer::create([
            'paymill_offer_id' => $response->getId(),
            'name' => $request->get('offer_name'),
            'amount' => $request->get('offer_amount'),
            'interval' => $interval,
            'currency' => $currency,
            'promo_code' => $request->get('promo_code'),
            'use_on_sign_up' => $request->get('use_on_sign_up'),
            'disabled' => !$request->get('enable_offer')
        ]);

        // Return response
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->setSuccessMessage(trans('offers.offer_created'));
        return response($ajaxResponse->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit offer name.
     *
     * @param EditOfferNameRequest $request
     * @return mixed
     */
    public function editOfferName(EditOfferNameRequest $request) {

        // Create paymill request
        $paymillRequest = new \Paymill\Request(env('PAYMILL_API_KEY'));

        // Create new paymill offer object
        $offer = new \Paymill\Models\Request\Offer();

        // Set new name
        $offer->setName($request->get('offer_name'))
            ->updateSubscriptions(true);

        // Save on paymill
        $paymillResponse = $paymillRequest->update($offer);

        // Update offer name in database
        $offer = Offer::where('paymill_offer_id', $paymillResponse->getId());
        $offer->name = $paymillResponse->name;
        $offer->save();

        // Return ajax response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('offers.offer_name_updated'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit offer amount.
     *
     * @param EditOfferAmountRequest $request
     */
    public function editOfferAmount(EditOfferAmountRequest $request) {

        // Create paymill request
        $paymillRequest = new \Paymill\Request(env('PAYMILL_API_KEY'));

        // Create new paymill offer object and set new amount
        $offer = new \Paymill\Models\Request\Offer();
        $offer->setAmount($request->get('offer_amount'))
            ->updateSubscriptions($request->get('update_subscriptions'));

        // Save on paymill
        $paymillResponse = $paymillRequest->update($offer);

        // Update offer amount in database
        $offer = Offer::where('paymill_offer_id', $paymillResponse->getId());
        $offer->amount = $paymillResponse->amount;
        $offer->save();

        // Return json response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('offers.offer_amount_updated'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit offer promo code.
     *
     * @param EditOfferPromoCodeRequest $request
     * @return mixed
     */
    public function editOfferPromoCode(EditOfferPromoCodeRequest $request) {

        // Update offer promo code
        $offer = Offer::find($request->get('offer_id'));
        $offer->promo_code = $request->get('promo_code');
        $offer->save();

        // Return json response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('offers.promo_code_updated'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Use offer on sign up.
     *
     * @param UseOfferOnSignUpRequest $request
     * @return mixed
     */
    public function useOfferOnSignUp(UseOfferOnSignUpRequest $request) {

        // Remove other offer used on sign up
        Offer::where('use_on_sign_up', true)->update(['use_on_sign_up' => false]);

        // Update current offer to be used on sign up
        $offer = Offer::find($request->get('offer_id'));
        $offer->use_on_sign_up = true;
        $offer->save();

        // Return json response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('offers.offer_will_be_used_on_sign_up'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Enable offer.
     *
     * @param EnableOfferRequest $request
     * @return mixed
     */
    public function enableOffer(EnableOfferRequest $request) {

        $offer = Offer::find($request->get('offer_id'));
        $offer->disabled = false;
        $offer->save();

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('offers.offer_enabled'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Disable offer.
     *
     * @param DisableOfferRequest $request
     * @return mixed
     */
    public function disableOffer(DisableOfferRequest $request) {

        $offer = Offer::find($request->get('offer_id'));
        $offer->disabled = true;
        $offer->save();

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('offers.offer_disabled'));
        return response($response->get())->header('Content-Type', 'application/json');
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