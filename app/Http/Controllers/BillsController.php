<?php

namespace App\Http\Controllers;

use App\ApplicationProduct;
use App\Bill;
use App\BillApplicationProduct;
use App\BillProduct;
use App\Campaign;
use App\Client;
use App\Events\HomepageAccessed;
use App\Events\UserCreatedNewBill;
use App\Events\UserDeletedBill;
use App\Helpers\AjaxResponse;
use App\Helpers\Bills;
use App\Helpers\Campaigns;
use App\Helpers\Clients;
use App\Helpers\Settings;
use App\Http\Requests\Bill\AddProductRequest;
use App\Http\Requests\Bill\CreateBillRequest;
use App\Http\Requests\Bill\EditOtherDetailsRequest;
use App\Http\Requests\Bill\EditPaymentTermRequest;
use App\Http\Requests\Bill\EditProductDiscountRequest;
use App\Http\Requests\Bill\EditProductPageRequest;
use App\Http\Requests\Bill\EditProductPriceRequest;
use App\Http\Requests\Bill\SuggestClientRequest;
use App\Http\Requests\Bill\SuggestProductRequest;
use App\Http\Requests\Bill\EditProductQuantityRequest;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Products;

/**
 * Handle the work with bills
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillsController extends BaseController {

    /**
     * Initialize required stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render bills index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('bills.index');
    }

    /**
     * Return paginated bills in json format.
     *
     * @param Request $request
     * @return mixed
     * @internal param bool $first_time
     */
    public function getBills(Request $request) {

        // Fire event
        event(new HomepageAccessed(Auth::user()->id));

        // Build config and paginate bills
        $billsConfig = ['page' => $request->get('page'), 'bau' => 'ss'];

        return Bills::get($billsConfig);
    }

    /**
     * Query database to return product suggestions based on given code.
     *
     * @param SuggestProductRequest $request
     * @return mixed
     */
    public function suggestProducts(SuggestProductRequest $request) {
        return Products::suggestProducts($request->get('product_code'));
    }

    /**
     * Return client suggestions based on given name.
     *
     * @param SuggestClientRequest $request
     * @return mixed
     */
    public function suggestClients(SuggestClientRequest $request) {
        return Clients::suggestClients($request->get('name'));
    }

    /**
     * Handle creation of new bill.
     *
     * @param CreateBillRequest $request
     * @return array
     */
    public function create(CreateBillRequest $request) {

        // Save request data
        $clientName = $request->get('client');
        $useCurrentCampaign = $request->get('use_current_campaign');
        $campaignYear = $request->get('campaign_year');
        $campaignNumber = $request->get('campaign_number');

        $client = DB::table('clients')->where('name', $clientName)->where('user_id', Auth::user()->id)->first();

        // Create new client if not exists
        if (!$client) {
            $client = new Client();
            $client->user_id = Auth::user()->id;
            $client->name = $clientName;
            $client->save();
        }

        // Create new bill
        $bill = new Bill();
        $bill->client_id = $client->id;
        $bill->user_id = Auth::user()->id;

        $campaign = Campaigns::current();

        // Check if current campaign should be used
        if (!$useCurrentCampaign) {
            $campaign = Campaign::where('year', $campaignYear)->where('number', $campaignNumber)->first();
        }

        $bill->campaign_id = $campaign->id;
        $bill->campaign_order = Campaigns::autoDetermineOrderNumber($campaign, $client->id);
        $bill->save();

        event(new UserCreatedNewBill(Auth::user()->id, $bill->id));

        // Return response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('bills.bill_created'));
        return response($response->get());
    }

    /**
     * Delete bill that match given $billId
     *
     * @param int $billId
     * @return array
     */
    public function delete($billId) {

        $response = new AjaxResponse();

        // Make sure bill exists and belongs to current user
        if (!Bill::where('id', $billId)->where('user_id', Auth::user()->id)->count()) {
            $response->setFailMessage(trans('bills.bill_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        DB::table('bills')->where('id', $billId)->where('user_id', Auth::user()->id)->delete();
        event(new UserDeletedBill(Auth::user()->id, $billId));

        $response->setSuccessMessage(trans('bills.bill_deleted'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Render bill index page.
     *
     * @param int $billId
     * @return $this
     */
    public function bill($billId) {
        return view('bill.index')->with('billId', $billId);
    }

    /**
     * Return bill data in json format.
     *
     * @param int $billId
     * @return mixed
     */
    public function getBill($billId) {

        $billsHelper = new Bills();

        // todo check if bill belongs to current user

        return $billsHelper->getBill($billId);

    }

    /**
     * Delete entire bill.
     *
     * @param int $billId
     * @return mixed
     */
    public function deleteBill($billId) {
        return Bills::deleteBill($billId);
    }

    /**
     * Add product to bill.
     *
     * @param int $billId
     * @param AddProductRequest $request
     * @return mixed
     */
    public function addProduct($billId, AddProductRequest $request) {
        return Products::insertProduct($billId, $request->all());
    }

    /**
     * Add not existent product to bill.
     *
     * @param int $billId
     * @param Requests\Bill\AddNotExistentProductRequest $request
     * @return mixed
     */
    public function addNotExistentProduct($billId, Requests\Bill\AddNotExistentProductRequest $request) {

        $product = new Product();
        $product->user_id = Auth::user()->id;
        $product->code = $request->get('product_code');
        $product->name = $request->get('product_name');
        $product->save();

        return Products::insertProduct($billId, $request->all());
    }

    /**
     * Edit bill other details.
     *
     * @param int $billId
     * @param EditOtherDetailsRequest $request
     * @return mixed
     */
    public function editOtherDetails($billId, EditOtherDetailsRequest $request) {
        return Bills::updateOtherDetails($billId, $request->get('other_details'));
    }

    /**
     * Edit bill payment term.
     *
     * @param int $billId
     * @param EditPaymentTermRequest $request
     * @return mixed
     */
    public function editPaymentTerm($billId, EditPaymentTermRequest $request) {
        return Bills::updatePaymentTerm($billId, $request->get('payment_term'));
    }

    /**
     * Handle product page edit.
     *
     * @param int $billId
     * @param EditProductPageRequest $request
     * @return mixed
     */
    public function editPage($billId, EditProductPageRequest $request) {

        $data = Bills::getBillProductEditConfig($request, $billId, 'page');
        return Bills::handleBillProductEdit($data);

    }

    /**
     * Handle product quantity edit.
     *
     * @param int $billId
     * @param EditProductQuantityRequest $request
     * @return mixed
     */
    public function editQuantity($billId, EditProductQuantityRequest $request) {

        $data = Bills::getBillProductEditConfig($request, $billId, 'quantity');
        return Bills::handleBillProductEdit($data);

    }

    /**
     * Handle product price edit.
     *
     * @param int $billId
     * @param EditProductPriceRequest $request
     * @return mixed
     */
    public function editPrice($billId, EditProductPriceRequest $request) {

        $data = Bills::getBillProductEditConfig($request, $billId, 'price');
        return Bills::handleBillProductEdit($data);

    }

    /**
     * Handle product discount edit.
     *
     * @param int $billId
     * @param EditProductDiscountRequest $request
     * @return mixed
     */
    public function editDiscount($billId, EditProductDiscountRequest $request) {

        $data = Bills::getBillProductEditConfig($request, $billId, 'discount');
        return Bills::handleBillProductEdit($data);

    }

    /**
     * Delete product form bill.
     *
     * @param int $billId
     * @param int $productId
     * @param int $billProductId
     * @param string $code
     * @param Requests\DeleteProductFromBillRequest $request
     * @return mixed
     */
    public function deleteProduct($billId, $productId, $code, $billProductId, Requests\DeleteProductFromBillRequest $request) {

        return Bills::handleBillProductDelete([
            'billId' => $billId,
            'productId' => $productId,
            'billProductId' => $billProductId,
            'productCode' => $code
        ]);

    }

    /**
     * Mark bill as paid.
     *
     * @param int $billId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function markAsPaid($billId) {
        return Bills::markAsPaid($billId);
    }

    /**
     * Mark bill as unpaid.
     *
     * @param int $billId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function markAsUnpaid($billId) {
        return Bills::markAsUnpaid($billId);
    }

}
