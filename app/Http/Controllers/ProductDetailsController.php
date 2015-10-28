<?php

namespace App\Http\Controllers;
use App\ApplicationProduct;
use App\Helpers\Products;
use App\Product;
use Illuminate\Support\Facades\Auth;

/**
 * Handle each product apart
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductDetailsController extends BaseController {

    /**
     * Render index page.
     *
     * @param $productCode
     * @return \Illuminate\View\View
     */
    public function index($productCode) {
        return view('product-details')->with('productCode', $productCode);
    }

    public function get($productCode) {
        return Products::details($productCode);
    }

}