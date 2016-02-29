<?php

namespace App\Http\Controllers\Bills;

use App\Helpers\Bills;
use App\Helpers\Clients;
use App\Helpers\Products;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Bill\AddNotExistentProductRequest;
use App\Http\Requests\Bill\AddProductRequest;
use App\Http\Requests\Bill\EditOtherDetailsRequest;
use App\Http\Requests\Bill\EditPaymentTermRequest;
use App\Http\Requests\Bill\EditProductDiscountRequest;
use App\Http\Requests\Bill\EditProductPageRequest;
use App\Http\Requests\Bill\EditProductPriceRequest;
use App\Http\Requests\Bill\EditProductQuantityRequest;
use App\Http\Requests\Bill\SuggestClientRequest;
use App\Http\Requests\Bill\SuggestProductRequest;
use App\Http\Requests\DeleteProductFromBillRequest;
use App\Product;
use Auth;

/**
 * Bill page controller.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillController extends BaseController {

    /**
     * Initialize required stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render bill index page.
     *
     * @param int $billId
     * @return $this
     */
    public function index($billId) {
        return view('bill.index')->with('billId', $billId);
    }

    /**
     * Return bill data in json format.
     *
     * @param int $billId
     * @return mixed
     */
    public function get($billId) {

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
     * Add not existent product to bill.
     *
     * @param int $billId
     * @param AddNotExistentProductRequest $request
     * @return mixed
     */
    public function addNotExistentProduct($billId, AddNotExistentProductRequest $request) {

        $product = new Product();
        $product->user_id = Auth::user()->id;
        $product->code = $request->get('product_code');
        $product->name = $request->get('product_name');
        $product->save();

        return Products::insertProduct($billId, $request->all());
    }

    /**
     * Delete entire bill.
     *
     * @param int $billId
     * @return mixed
     */
    public function delete($billId) {
        return Bills::deleteBill($billId);
    }

    /**
     * Delete product form bill.
     *
     * @param int $billId
     * @param int $productId
     * @param int $billProductId
     * @param string $code
     * @param DeleteProductFromBillRequest $request
     * @return mixed
     */
    public function deleteProduct($billId, $productId, $code, $billProductId, DeleteProductFromBillRequest $request) {

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
}