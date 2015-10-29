<?php

namespace App\Http\Controllers;
use App\ApplicationProduct;
use App\Helpers\Products;
use App\Http\Requests\ProductDetails\DeleteProductRequest;
use App\Http\Requests\ProductDetails\EditProductCodeRequest;
use App\Http\Requests\ProductDetails\EditProductNameRequest;
use App\Product;
use Illuminate\Support\Facades\Auth;

/**
 * Handle each product apart
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductDetailsController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render index page.
     *
     * @param $productCode
     * @return \Illuminate\View\View
     */
    public function index($productCode) {
        return view('product-details')->with('productCode', $productCode);
    }

    /**
     * Get product details.
     *
     * @param string $productCode
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function get($productCode) {
        return Products::details($productCode);
    }

    /**
     * Handle product name edit.
     *
     * @param string $productCode
     * @param EditProductNameRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editName($productCode, EditProductNameRequest $request) {
        return Products::editName($productCode, $request->get('id'), $request->get('name'));
    }

    /**
     * Handle product code edit.
     *
     * @param string $productCode
     * @param EditProductCodeRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editCode($productCode, EditProductCodeRequest $request) {
        return Products::editCode($productCode, $request->get('id'), $request->get('code'));
    }

    /**
     * Handle custom product delete.
     *
     * @param string $productCode
     * @param DeleteProductRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($productCode, DeleteProductRequest $request) {
        return Products::delete($productCode, $request->get('id'));
    }

}