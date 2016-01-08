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
     * Render offer page.
     *
     * @param int $offerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function offer($offerId) {
        return view('admin-center.subscriptions.offer')->with('offerId', $offerId);
    }

    /**
     * @param int $offerId
     * @return mixed
     */
    public function getOne($offerId) {
        $response = new AjaxResponse();
        $response->setSuccessMessage('success');
        $response->addExtraFields(['offer' => Offer::countAssociatedSubscriptions()->where('offers.id', $offerId)->first()]);
        return response($response->get())->header('Content-Type', 'application/json');
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

        $promoCode = $request->get('promo_code');
        $enableOffer = $request->get('enable_offer');
        $useOnSignUp = $request->get('use_on_sign_up');

        // If this offer will be used on sign up make sure it is the only one
        if ($useOnSignUp) {
            Offer::where('use_on_sign_up', true)->update(['use_on_sign_up' => false]);
            $promoCode = '';
            $enableOffer = false;
        }

        // An enabled offer can not be used on sign up
        if ($enableOffer) {
            $useOnSignUp = false;
        }

        // Save in database
        Offer::create([
            'paymill_offer_id' => $response->getId(),
            'name' => $request->get('offer_name'),
            'amount' => $request->get('offer_amount'),
            'interval' => $interval,
            'currency' => $currency,
            'promo_code' => $promoCode,
            'use_on_sign_up' => (bool)$useOnSignUp,
            'disabled' => !(bool)$enableOffer
        ]);

        // Return response
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->setSuccessMessage(trans('offers.offer_created'));
        return response($ajaxResponse->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit offer name.
     *
     * @param int $offerId
     * @param EditOfferNameRequest $request
     * @return mixed
     */
    public function editOfferName($offerId, EditOfferNameRequest $request) {

        $response = new AjaxResponse();
        $offerModel = Offer::where('id', $offerId)->first();

        // Make sure offer exists
        if (!$offerModel) {
            $response->setFailMessage(trans('offers.offer_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        // Create paymill request
        $paymillRequest = new \Paymill\Request(env('PAYMILL_API_KEY'));

        // Create new paymill offer object
        $offer = new \Paymill\Models\Request\Offer();

        // Set new name
        $offer->setId($offerModel->paymill_offer_id)
            ->setName($request->get('offer_name'));

        // Save on paymill
        $paymillResponse = $paymillRequest->update($offer);

        // Update offer name in database
        $offerModel->name = $request->get('offer_name');
        $offerModel->save();

        // Return ajax response
        $response->setSuccessMessage(trans('offers.offer_name_updated'));
        $response->addExtraFields(['offer' => Offer::countAssociatedSubscriptions()->where('offers.id', $offerId)->first()]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit offer amount.
     *
     * @param int $offerId
     * @param EditOfferAmountRequest $request
     * @return
     */
    public function editOfferAmount($offerId, EditOfferAmountRequest $request) {

        $response = new AjaxResponse();
        $offerModel = Offer::where('id', $offerId)->first();

        // Make sure offer exists
        if (!$offerModel) {
            $response->setFailMessage(trans('offers.offer_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        // Create paymill request
        $paymillRequest = new \Paymill\Request(env('PAYMILL_API_KEY'));

        // Create new paymill offer object and set new amount
        $offer = new \Paymill\Models\Request\Offer();
        $offer->setId($offerModel->paymill_offer_id)
            ->setAmount($request->get('offer_amount'));

        // Save on paymill
        $paymillResponse = $paymillRequest->update($offer);

        // Update offer amount in database
        $offerModel->amount = $request->get('offer_amount');
        $offerModel->save();

        // Return json response
        $response->setSuccessMessage(trans('offers.offer_amount_updated'));
        $response->addExtraFields(['offer' => Offer::countAssociatedSubscriptions()->where('offers.id', $offerId)->first()]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit offer promo code.
     *
     * @param int $offerId
     * @param EditOfferPromoCodeRequest $request
     * @return mixed
     */
    public function editOfferPromoCode($offerId, EditOfferPromoCodeRequest $request) {

        $offer = Offer::find($offerId);
        $response = new AjaxResponse();

        // Make sure offer exists
        if (!$offer) {
            $response->setFailMessage(trans('offers.offer_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        // Update offer promo code
        $offer->promo_code = $request->get('promo_code');
        $offer->save();

        // Return json response
        $response->setSuccessMessage(trans('offers.promo_code_updated'));
        $response->addExtraFields(['offer' => Offer::countAssociatedSubscriptions()->where('offers.id', $offerId)->first()]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Use offer on sign up.
     *
     * @param $offerId
     * @param UseOfferOnSignUpRequest $request
     * @return mixed
     */
    public function useOfferOnSignUp($offerId, UseOfferOnSignUpRequest $request) {

        $response = new AjaxResponse();
        $offer = Offer::where('id', $offerId)->first();

        // Make sure offer exists
        if (!$offer) {
            $response->setFailMessage(trans('offers.offer_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        // Remove other offer used on sign up
        Offer::where('use_on_sign_up', true)->update(['use_on_sign_up' => false]);

        // Update current offer to be used on sign up
        $offer->use_on_sign_up = true;
        $offer->save();

        // Return json response
        $response->setSuccessMessage(trans('offers.this_offer_is_used_on_sign_up'));
        $response->addExtraFields(['offer' => Offer::countAssociatedSubscriptions()->where('offers.id', $offerId)->first()]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Enable offer.
     *
     * @param int $offerId
     * @param EnableOfferRequest $request
     * @return mixed
     */
    public function enableOffer($offerId, EnableOfferRequest $request) {

        $offer = Offer::find($offerId);
        $response = new AjaxResponse();

        // Make sure offer exists
        if (!$offer) {
            $response->setFailMessage(trans('offers.offer_not_found'));
            return response($response->get());
        }

        $offer->disabled = false;
        $offer->save();

        $response->setSuccessMessage(trans('offers.offer_enabled'));
        $response->addExtraFields(['offer' => Offer::countAssociatedSubscriptions()->where('offers.id', $offerId)->first()]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Disable offer.
     *
     * @param int $offerId
     * @param DisableOfferRequest $request
     * @return mixed
     */
    public function disableOffer($offerId, DisableOfferRequest $request) {

        $offer = Offer::find($offerId);
        $response = new AjaxResponse();

        // Make sure offer exists
        if (!$offer) {
            $response->setFailMessage(trans('offers.offer_not_found'));
            return response($response->get());
        }

        $offer->disabled = true;
        $offer->save();

        $response->setSuccessMessage(trans('offers.offer_disabled'));
        $response->addExtraFields(['offer' => Offer::countAssociatedSubscriptions()->where('offers.id', $offerId)->first()]);
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