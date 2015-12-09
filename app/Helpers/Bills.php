<?php

namespace App\Helpers;
use App\Bill;
use App\BillApplicationProduct;
use App\BillProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Handle work with bills
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Bills {

    /**
     * Query database for products of a given bill.
     *
     * @param int $billId
     * @return mixed
     */
    public function getBill($billId) {

        $productIds = $this->getProductIds($billId);
        $applicationProductIds = $this->getApplicationProductIds($billId);

        $firstQuery = DB::table('products')
            ->whereIn('products.id', $productIds)
            ->where('bill_products.bill_id', $billId)
            ->leftJoin('bill_products', 'bill_products.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.code',
                'bill_products.id as bill_product_id',
                'bill_products.page',
                'bill_products.quantity',
                'bill_products.price',
                'bill_products.discount',
                'bill_products.calculated_discount',
                'bill_products.final_price'
            );

        $secondQuery = DB::table('application_products')->whereIn('application_products.id', $applicationProductIds)
            ->where('bill_application_products.bill_id', $billId)
            ->leftJoin('bill_application_products', 'bill_application_products.product_id', '=', 'application_products.id')
            ->select(
                'application_products.id',
                'application_products.name',
                'application_products.code',
                'bill_application_products.id as bill_product_id',
                'bill_application_products.page',
                'bill_application_products.quantity',
                'bill_application_products.price',
                'bill_application_products.discount',
                'bill_application_products.calculated_discount',
                'bill_application_products.final_price'
            )->union($firstQuery)->orderBy('page', 'asc')->get();

        $bill = Auth::user()->bills()->where('bills.id', $billId)
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->select(
                'clients.id as client_id',
                'clients.name as client_name',
                'bills.campaign_order',
                'bills.campaign_number',
                'bills.campaign_year',
                'bills.other_details',
                'bills.payment_term',
                'bills.paid'
            )
            ->first();

        if ($bill->payment_term === '0000-00-00') {
            $bill->payment_term = false;
        }

        // Calculate bill price, saved money and check if discount column should be displayed
        $showDiscount = false;
        $price = 0;
        $finalPrice = 0;
        foreach ($secondQuery as $billProduct) {
            if ($billProduct->discount) {
                $showDiscount = true;
            }
            $price += $billProduct->price;
            $finalPrice += $billProduct->final_price;
        }

        $toPay = $finalPrice;
        $savedMoney = $price-$finalPrice;

        return [
            'to_pay' => $toPay,
            'saved_money' => $savedMoney,
            'total' => $price,
            'number_of_products' => count($secondQuery),
            'show_discount_column' => $showDiscount,
            'show_other_details_info' => true,
            'products' => $secondQuery,
            'data' => $bill
        ];

    }

    /**
     * @param bool $onlyPaidBills
     * @return mixed
     */
    public static function get($onlyPaidBills = false) {

        $paid = 0;
        if ($onlyPaidBills) {
            $paid = 1;
        }

        $bills = Bill::select(
            'bills.id', 'bills.campaign_order', 'bills.campaign_number', 'bills.campaign_year',
            'bills.other_details', 'bills.created_at', 'clients.name as client_name'
        )->where('bills.user_id', Auth::user()->id)
        ->where('bills.paid', $paid)
        ->orderBy('bills.created_at', 'desc')
        ->join('clients', function($join){
            $join->on('bills.client_id', '=', 'clients.id');
        })
        ->paginate(Settings::displayedBills());

        // Append price to each bill
        foreach ($bills->items() as $bill) {
            $bill['human_date'] = date('d-m-Y', time($bill->created_at));
            $bill['price'] = Bills::getPrice($bill->id);
        }

        return $bills;
    }

    /**
     * Get bill price.
     *
     * @param int $billId
     * @return mixed
     */
    public static function getPrice($billId) {

        $bill = Bill::where('id', $billId)->where('user_id', Auth::user()->id)->first();
        $price = $bill->products()->sum('final_price') + $bill->applicationProducts()->sum('final_price');
        return $price;
    }

    public static function deleteBill($billId) {

        $response = new AjaxResponse();
        $response->setFailMessage(trans('common.general_error'));

        // Make sure bill belongs to current user
        $bill = Auth::user()->bills()->where('id', $billId)->first();
        if (!$bill) {
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // Delete bill
        Auth::user()->bills()->where('id', $billId)->delete();

        // Check if bill was deleted
        if (Auth::user()->bills()->where('id', $billId)->count()) {
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        $response->setSuccessMessage(trans('bill.deleted'));
        return response($response->get())->header('Content-Type', 'application/json');

    }

    /**
     * Update bill other details.
     *
     * @param int $billId
     * @param string $otherDetails
     * @return mixed
     */
    public static function updateOtherDetails($billId, $otherDetails) {

        $response = new AjaxResponse();

        $otherDetails = nl2br($otherDetails);

        // Make sure bill exists
        $bill = Auth::user()->bills()->where('id', $billId)->first();

        if (!$bill) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        Auth::user()->bills()->where('id', $billId)->update([
            'other_details' => $otherDetails
        ]);

        $response->setSuccessMessage(trans('bill.other_details_updated'));
        $response->addExtraFields(['other_details' => $otherDetails]);
        return response($response->get())->header('Content-Type', 'application/json');

    }

    /**
     * Update bill payment term.
     *
     * @param int $billId
     * @param string $paymentTerm
     * @return mixed
     */
    public static function updatePaymentTerm($billId, $paymentTerm) {

        $response = new AjaxResponse();

        // Check if bill exists and belongs to current user
        $bill = Auth::user()->bills()->where('id', $billId)->first();

        if (!$bill) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        Auth::user()->bills()->where('id', $billId)->update([
            'payment_term' => $paymentTerm
        ]);

        $response->setSuccessMessage(trans('bill.payment_term_updated'));
        $response->addExtraFields(['payment_term' => $paymentTerm]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Handle database operations to delete a product from a given bill.
     *
     * @param array $data
     *      @option int billId
     *      @option int productId
     *      @option int billProductId
     *      @option string productCode
     * @return mixed
     */
    public static function handleBillProductDelete($data = []) {

        $response = new AjaxResponse();

        // Make sure bill exists
        $bill = Auth::user()->bills()->where('id', $data['billId'])->first();

        if (!$bill) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        $response->setSuccessMessage(trans('common.product_deleted'));
        $successResponse = response($response->get())->header('Content-Type', 'application/json');

        // Check if is custom product
        if (Products::isCustomProduct($data['productId'], $data['productCode'])) {

            BillProduct::where('id', $data['billProductId'])->where('bill_id', $data['billId'])->delete();
            return $successResponse;
        }

        // Check if is application product
        if (Products::isApplicationProduct($data['productId'], $data['productCode'])) {

            BillApplicationProduct::where('id', $data['billProductId'])->where('bill_id', $data['billId'])->delete();
            return $successResponse;
        }

        // If we arrive here something went wrong
        $response->setFailMessage(trans('common.general_error'));
        return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
    }

    /**
     * Handle database operations to edit a bill product.
     *
     * @param array $data
     *      @option int billId
     *      @option int productId
     *      @option int billProductId
     *      @option string productCode
     *      @option string columnToUpdate
     *      @option string newValue
     * @return mixed
     */
    public static function handleBillProductEdit($data = []) {

        $response = new AjaxResponse();

        // Query for bill
        $bill = Auth::user()->bills()->where('id', $data['billId'])->first();

        // Now make sure exists in database
        if (!$bill) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // We will use this variable to check if operation was successful
        $success = false;

        // Check if is a custom product
        if (Products::isCustomProduct($data['productId'], $data['productCode'])) {

            // Get product details and update with new data
            $product = BillProduct::where('id', $data['billProductId'])->first();
            BillProduct::where('id', $data['billProductId'])->update(Bills::getDataToUpdateOnEdit($data['columnToUpdate'], $data['newValue'], $product));
            $success = true;

        }

        // Check if is an application product
        if (Products::isApplicationProduct($data['productId'], $data['productCode'])) {

            // Get product details and update with new data
            $product = BillApplicationProduct::where('id', $data['billProductId'])->first();
            BillApplicationProduct::where('id', $data['billProductId'])->update(Bills::getDataToUpdateOnEdit($data['columnToUpdate'], $data['newValue'], $product));
            $success = true;

        }

        // Check if update was successful
        if ($success) {
            $response->setSuccessMessage(trans('bill.' . $data['columnToUpdate'] . '_updated'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        // If we arrive here something is wrong
        $response->setFailMessage(trans('common.general_error'));
        return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');

    }

    /**
     * Return a config used by handleBillProductEdit method.
     *
     * @param $request
     * @param int $billId
     * @param string $columnToUpdate
     * @param string $newValueKey
     * @return array
     */
    public static function getBillProductEditConfig($request, $billId, $columnToUpdate, $newValueKey = '') {
        $config = [
            'billId' => $billId,
            'productId' => $request->get('product_id'),
            'billProductId' => $request->get('bill_product_id'),
            'productCode' => $request->get('product_code'),
            'columnToUpdate' => $columnToUpdate,
        ];

        if (strlen($newValueKey) < 1) {
            $newValueKey = 'product_' . $columnToUpdate;
        }

        $config['newValue'] = $request->get($newValueKey);

        return $config;
    }

    /**
     * Check if given bill belongs to currently authenticated user.
     *
     * @param int $billId
     * @return mixed
     */
    public static function belongsToAuthUser($billId) {
        return Bill::where('id', $billId)->where('user_id', Auth::user()->id)->count();
    }

    /**
     * Mark bill as paid.
     *
     * @param int $billId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public static function markAsPaid($billId) {

        $response = new AjaxResponse();
        Auth::user()->bills()->where('id', $billId)->update(['paid' => 1]);

        $response->setSuccessMessage(trans('bill.marked_as_paid'));
        $response->addExtraFields(['paid' => 1]);
        return response($response->get());
    }

    /**
     * Mark bill as unpaid.
     *
     * @param int $billId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public static function markAsUnpaid($billId) {

        $response = new AjaxResponse();
        Auth::user()->bills()->where('id', $billId)->update(['paid' => 0]);

        $response->setSuccessMessage(trans('bill.marked_as_unpaid'));
        $response->addExtraFields(['paid' => 0]);
        return response($response->get());

    }

    /**
     * Return an array with columns to update on bill product edit.
     *
     * @param string $columnToUpdate
     * @param string|int $newValue
     * @param Product $product
     * @return array
     */
    private static function getDataToUpdateOnEdit($columnToUpdate, $newValue, $product) {

        if ($columnToUpdate === 'page') {

            return [
                $columnToUpdate => $newValue
            ];
        }

        // When quantity is updated, update price, calculated discount and final price
        if ($columnToUpdate === 'quantity') {

            $toUpdate = [
                $columnToUpdate => $newValue
            ];

            $toUpdate['price'] = Products::newPrice($product->price, $product->quantity, $newValue);
            $toUpdate['calculated_discount'] = Products::discount($toUpdate['price'], $product->discount);
            $toUpdate['final_price'] = $toUpdate['price'] - $toUpdate['calculated_discount'];

            return $toUpdate;
        }

        // When price is updated, update calculated discount and final price
        if ($columnToUpdate === 'price') {

            $toUpdate = [
                $columnToUpdate => $newValue * $product->quantity
            ];

            $toUpdate['calculated_discount'] = Products::discount($newValue * $product->quantity, $product->discount);
            $toUpdate['final_price'] = ($newValue * $product->quantity) - $toUpdate['calculated_discount'];

            return $toUpdate;
        }

        // When discount is updated, update calculated discount and final price
        if ($columnToUpdate === 'discount') {

            $toUpdate = [
                $columnToUpdate => $newValue
            ];

            $toUpdate['calculated_discount'] = Products::discount($product->price, $newValue);
            $toUpdate['final_price'] = $product->price - $toUpdate['calculated_discount'];

            return $toUpdate;
        }

    }

    /**
     * @param int $billId
     * @return array
     */
    private function getProductIds($billId) {

        $bill = Bill::find($billId);

        if (!$bill) {
            return [];
        }

        $productIds = [];
        $products = $bill->products()->select('product_id as id')->get();

        foreach ($products as $product) {
            $productIds[] = $product->id;
        }

        return $productIds;

    }

    /**
     * @param int $billId
     * @return array
     */
    private function getApplicationProductIds($billId) {

        $bill = Bill::find($billId);

        if (!$bill) {
            return [];
        }

        $applicationProductIds = [];
        $applicationProducts = $bill->applicationProducts()->select('product_id as id')->get();

        foreach ($applicationProducts as $applicationProduct) {
            $applicationProductIds[] = $applicationProduct->id;
        }

        return $applicationProductIds;

    }

}