<?php

namespace App\Http\Controllers;

use App\ApplicationProduct;
use App\Bill;
use App\BillApplicationProduct;
use App\BillProduct;
use App\Client;
use App\Helpers\AjaxResponse;
use App\Helpers\Bills;
use App\Http\Requests\Bill\EditProductDiscountRequest;
use App\Http\Requests\Bill\EditProductPriceRequest;
use App\Http\Requests\CreateBillRequest;
use App\Http\Requests\EditProductPageFromBillRequest;
use App\Http\Requests\Bill\EditProductQuantityRequest;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return $billsHelper->getBillProducts($billId);

    }

    public function addProduct() {
        //
    }

    public function editPaymentTerm() {
        //
    }

    /**
     * Handle product page edit.
     *
     * @param int $billId
     * @param EditProductPageFromBillRequest $request
     * @return mixed
     */
    public function editPage($billId, EditProductPageFromBillRequest $request) {

        $handler = 'page';

        $data = [
            'billId' => $billId,
            'productId' => $request->get('product_id'),
            'productCode' => $request->get('product_code'),
            'columnToUpdate' => $handler,
            'newValue' => $request->get('product_page')
        ];

        return $this->handleProductEdit('page', $data);

    }

    /**
     * Handle product quantity edit.
     *
     * @param int $billId
     * @param EditProductQuantityRequest $request
     * @return mixed
     */
    public function editQuantity($billId, EditProductQuantityRequest $request) {

        $handler = 'quantity';

        $data = [
            'billId' => $billId,
            'productId' => $request->get('product_id'),
            'productCode' => $request->get('product_code'),
            'columnToUpdate' => $handler,
            'newValue' => $request->get('product_quantity')
        ];

        return $this->handleProductEdit($handler, $data);

    }

    /**
     * Handle product price edit.
     *
     * @param int $billId
     * @param EditProductPriceRequest $request
     * @return mixed
     */
    public function editPrice($billId, EditProductPriceRequest $request) {

        $handler = 'price';

        $data = [
            'billId' => $billId,
            'productId' => $request->get('product_id'),
            'productCode' => $request->get('product_code'),
            'columnToUpdate' => $handler,
            'newValue' => $request->get('product_price')
        ];

        return $this->handleProductEdit($handler, $data);

    }

    /**
     * Handle product discount edit.
     *
     * @param int $billId
     * @param EditProductDiscountRequest $request
     * @return mixed
     */
    public function editDiscount($billId, EditProductDiscountRequest $request) {

        $handler = 'discount';

        $data = [
            'billId' => $billId,
            'productId' => $request->get('product_id'),
            'productCode' => $request->get('product_code'),
            'columnToUpdate' =>$handler,
            'newValue' => $request->get('product_discount')
        ];

        return $this->handleProductEdit($handler, $data);

    }

    /**
     * Delete product form bill.
     *
     * @param int $billId
     * @param int $productId
     * @param string $code
     * @param Requests\DeleteProductFromBillRequest $request
     * @return mixed
     */
    public function deleteProduct($billId, $productId, $code, Requests\DeleteProductFromBillRequest $request) {

        $response = new AjaxResponse();

        // Make sure bill exists
        $bill = Auth::user()->bills()->where('id', $billId)->first();

        if (!$bill) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // Check if is an application product
        if ($this->isApplicationProduct($productId, $code)) {

            BillApplicationProduct::where('product_id', $productId)->where('bill_id', $bill->id)->delete();
            $response->setSuccessMessage(trans('common.product_deleted'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        // Check if is a custom product
        if ($this->isCustomProduct($productId, $code)) {

            BillProduct::where('product_id', $productId)->where('bill_id', $bill->id)->delete();
            $response->setSuccessMessage(trans('common.product_deleted'));
            return response($response->get())->header('Content-Type', 'application/json');

        }

        // If we arrive here something went wrong
        $response->setFailMessage(trans('common.general_error'));
        return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');

    }

    /**
     * Handle edit of product page, quantity, price or discount in function of given parameters.
     *
     * @param string $handler Can be: page, quantity, price and discount
     * @param array $data
     * @return mixed
     */
    private function handleProductEdit($handler = 'page', $data = []) {

        $response = new AjaxResponse();

        // Make sure bill exists
        $bill = Auth::user()->bills()->where('id', $data['billId'])->first();

        if (!$bill) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        $success = false;

        // Check if is a custom product
        if ($this->isCustomProduct($data['productId'], $data['productCode'])) {
            BillProduct::where('id', $data['productId'])->update([$data['columnToUpdate'] => $data['newValue']]);
            $success = true;
        }

        // Check if is an application product
        if ($this->isApplicationProduct($data['productId'], $data['productCode'])) {
            BillApplicationProduct::where('id', $data['productId'])->update([$data['columnToUpdate'] => $data['newValue']]);
            $success = true;
        }

        if ($success) {
            $response->setSuccessMessage(trans('bill.' . $data['columnToUpdate'] . '_updated'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        // If we arrive here something is wrong
        $response->setFailMessage(trans('common.general_error'));
        return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
    }

    /**
     * Check if given product exists in application products.
     *
     * @param int $id
     * @param string $code
     * @return mixed
     */
    private function isApplicationProduct($id, $code) {
        return ApplicationProduct::where('id', $id)->where('code', $code)->count();
    }

    /**
     * Check if given product is custom.
     *
     * @param int $id
     * @param string $code
     * @return mixed
     */
    private function isCustomProduct($id, $code) {
        return Product::where('id', $id)->where('code', $code)->where('user_id', Auth::user()->id)->count();
    }

}
