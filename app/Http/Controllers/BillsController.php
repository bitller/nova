<?php

namespace App\Http\Controllers;

use App\ApplicationProduct;
use App\Bill;
use App\BillApplicationProduct;
use App\BillProduct;
use App\Client;
use App\Helpers\AjaxResponse;
use App\Helpers\Bills;
use App\Http\Requests\CreateBillRequest;
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

    public function editPage() {
        //
    }

    public function editQuantity() {
        //
    }

    public function editPrice() {
        //
    }

    public function editDiscount() {
        //
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
        if (!$bill->count()) {
            $response->setFailMessage(trans('common.general_error'));
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
