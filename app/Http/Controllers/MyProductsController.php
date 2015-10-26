<?php

namespace App\Http\Controllers;

use App\ApplicationProduct;
use App\Helpers\AjaxResponse;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\CheckProductCodeRequest;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Handle work with products added by users
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MyProductsController extends BaseController {

    /**
     * Initialize required stuff
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('my-products');
    }

    /**
     * Paginate products
     *
     * @return mixed
     */
    public function getProducts() {
        return Product::where('user_id', Auth::user()->id)->orderBy('code', 'asc')->paginate(Settings::displayedCustomProducts());
    }

    /**
     * Insert new product in database
     *
     * @param AddProductRequest $request
     * @return mixed
     */
    public function addProduct(AddProductRequest $request) {

        $response = new AjaxResponse();
        $code = $request->get('code');

        // Make sure product code is available
        if ($this->isProductCodeAlreadyUsed($code)) {
            $response->setFailMessage(trans('my_products.product_code_used'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // Insert product
        $product = new Product();
        $product->name = $request->get('name');
        $product->code = $code;
        $product->user_id = Auth::user()->id;
        $product->save();

        $response->setSuccessMessage(trans('my_products.product_added'));

        return response($response->get())->header('Content-Type', 'application/json');

    }

    /**
     * Check if a product code is already used by application products or user products
     *
     * @param string $code
     * @return mixed
     */
    public function checkProductCode($code) {

        $response = new AjaxResponse();

        // Validation rules
        $validator = Validator::make(['code' => $code], [
            'code' => ['required', 'digits:5']
        ]);

        // Run validator
        if ($validator->fails()) {
            $response->setFailMessage($this->getValidatorFirstErrorMessage($validator->messages()));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // Check if product code is available
        if ($this->isProductCodeAlreadyUsed($code)) {
            $response->setFailMessage(trans('my_products.product_code_used'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        $response->setSuccessMessage(trans('my_products.product_code_available'));

        return response($response->get())->header('Content-Type', 'application/json');

    }

    /**
     * Allow user to delete own products
     *
     * @param int $productId
     * @return mixed
     */
    public function deleteProduct($productId) {

        $records = Product::where('user_id', Auth::user()->id)->count();

        Product::where('id', $productId)->where('user_id', Auth::user()->id)->delete();

        $response = [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('common.product_deleted')
        ];

        // Return success response if product was deleted
        if (Product::where('user_id', Auth::user()->id)->count() < $records) {
            return response($response)->header('Content-Type', 'application/json');
        }

        $response = [
            'success' => false,
            'title' => trans('common.fail'),
            'message' => trans('common.product_delete_error'),
        ];

        return response($response, 422)->header('Content-Type', 'application/json');

    }

    /**
     * Check if given product code is used
     *
     * @param string $code
     * @return bool
     */
    private function isProductCodeAlreadyUsed($code) {
        if (ApplicationProduct::where('code', $code)->count() || Product::where('code', $code)->where('user_id', Auth::user()->id)->count()) {
            return true;
        }

        return false;
    }

    private function getValidatorFirstErrorMessage($messages) {
        foreach ($messages->all() as $message) {
            return $message;
        }
    }

}