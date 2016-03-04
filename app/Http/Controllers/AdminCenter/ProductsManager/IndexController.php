<?php

namespace App\Http\Controllers\AdminCenter\ProductsManager;

use App\ApplicationProduct;
use App\Forms\AddNewApplicationProductForm;
use App\Helpers\AdminCenter\ProductsManager\ProductsManagerHelper;
use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\ProductsManager\AddNewApplicationProductRequest;
use App\Http\Requests\AdminCenter\ProductsManager\CheckIfProductCodeIsUsedRequest;
use App\Http\Requests\AdminCenter\ProductsManager\GetProductsRequest;
use App\Http\Requests\AdminCenter\ProductsManager\SearchProductsRequest;
use App\Product;

/**
 * Handle management of application products.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class IndexController extends BaseController {

    /**
     * Run middleware and initialize stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render products manager index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin-center.products-manager.index');
    }

    /**
     * Return application products.
     *
     * @param GetProductsRequest $request
     * @return mixed
     */
    public function get(GetProductsRequest $request) {
        return ApplicationProduct::orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Return application products that match given product code or name.
     *
     * @param SearchProductsRequest $request
     * @return mixed
     */
    public function search(SearchProductsRequest $request) {
        return ProductsManagerHelper::searchedBillsPagination($request->get('term'), $request->get('page'));
    }

    public function addNew(AddNewApplicationProductRequest $request) {

        $applicationProductForm = new AddNewApplicationProductForm($request->all());

        return $applicationProductForm->add();
    }

    /**
     * Check if given product code is used by some user or not.
     *
     * @param CheckIfProductCodeIsUsedRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function checkIfCodeIsUsed(CheckIfProductCodeIsUsedRequest $request, AjaxResponse $response) {

        $response->setSuccessMessage(trans('common.success'));

        // Assume product is not used and update status if is used
        $used = false;
        if (Product::where('code', $request->get('product_code'))->count() || ApplicationProduct::where('code', $request->get('product_code'))->count()) {
            $used = true;
        }

        $response->addExtraFields(['used' => $used]);

        return response($response->get())->header('Content-Type', 'application/json');
    }
}