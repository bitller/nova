<?php

namespace App\Http\Controllers;

use App\ApplicationProduct;
use App\Bill;
use App\BillApplicationProduct;
use App\BillProduct;
use App\Client;
use App\Helpers\AjaxResponse;
use App\Helpers\Bills;
use App\Http\Requests\Bill\AddProductRequest;
use App\Http\Requests\Bill\EditOtherDetailsRequest;
use App\Http\Requests\Bill\EditPaymentTermRequest;
use App\Http\Requests\Bill\EditProductDiscountRequest;
use App\Http\Requests\Bill\EditProductPriceRequest;
use App\Http\Requests\Bill\SuggestProductRequest;
use App\Http\Requests\CreateBillRequest;
use App\Http\Requests\EditProductPageFromBillRequest;
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
class BillsController extends Controller {

    /**
     * Initialize required stuff
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('bills');
    }

    /**
     * @return mixed
     */
    public function getBills() {

        $bills = Bill::select('bills.id', 'bills.campaign_number', 'bills.campaign_year', 'bills.payment_term', 'bills.other_details', 'clients.name as client_name')
            ->where('bills.user_id', Auth::user()->id)
            ->orderBy('bills.created_at', 'desc')
            ->join('clients', function($join) {
                $join->on('bills.client_id', '=', 'clients.id');
            })
            ->paginate(10);

        return $bills;
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
     * @param CreateBillRequest $request
     * @return array
     */
    public function create(CreateBillRequest $request) {

        // Create new client if not exists
        $client = DB::table('clients')->where('name', $request->get('client'))->first();
        if (!$client) {
            $client = new Client();
            $client->user_id = Auth::user()->id;
            $client->name = $request->get('client');
            $client->save();
        }

        $bill = new Bill();
        $bill->client_id = $client->id;
        $bill->user_id = Auth::user()->id;
        $bill->save();

        return [
            'success' => true,
            'message' => trans('bills.bill_created')
        ];
    }

    /**
     * Delete bill that match given $billId
     *
     * @param int $billId
     * @return array
     */
    public function delete($billId) {

        DB::table('bills')->where('id', $billId)->where('user_id', Auth::user()->id)->delete();

        return [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('bills.bill_deleted')
        ];

    }

    /**
     * @param int $billId
     * @return $this
     */
    public function bill($billId) {
        return view('bill')->with('billId', $billId);
    }

    /**
     * @param int $billId
     * @return mixed
     */
    public function getBill($billId) {

        $billsHelper = new Bills();

        // todo check if bill belongs to current user

        return $billsHelper->getBill($billId);

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
     * @param EditProductPageFromBillRequest $request
     * @return mixed
     */
    public function editPage($billId, EditProductPageFromBillRequest $request) {

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

}
