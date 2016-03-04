<?php

namespace App\Http\Controllers\AdminCenter\ProductsManager;
use App\ApplicationProduct;
use App\Helpers\AdminCenter\ProductsManager\ProductsManagerHelper;
use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\ProductsManager\GetProductRequest;

/**
 * Handle work with given application product.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductController extends BaseController {

    /**
     * ProductController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Render product details index page.
     *
     * @param int $productId
     * @param string $productCode
     * @return mixed
     */
    public function index($productId, $productCode) {
        return view('admin-center.products-manager.product')->with('productId', $productId)->with('productCode', $productCode);
    }

    /**
     * Get product data.
     *
     * @param int $productId
     * @param string $productCode
     * @param GetProductRequest $request
     * @param AjaxResponse $response
     * @return mixed
     */
    public function get($productId, $productCode, GetProductRequest $request, AjaxResponse $response) {

        // Make sure product exists
        if (!ApplicationProduct::where('code', $productCode)->where('id', $productId)->count()) {
            $response->setFailMessage(trans('common.general_error'));
            return response($response->get())->header('Content-Type', 'application/json');
        }

        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields([
            'product' => ProductsManagerHelper::productDetails($productCode, $productId)
        ]);

        return response($response->get())->header('Content-Type', 'application/json');
    }
}