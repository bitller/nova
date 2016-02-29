<?php

namespace App\Helpers\AdminCenter\ProductsManager;
use App\ApplicationProduct;
use App\Helpers\Settings;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Protected hlper methods to be used only inside products manager helpers.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProtectedHelpers {

    protected static function paginateSearchedProducts($searchTerm, $page) {

        // Query for results
        $results = \DB::table('application_products')
            ->where('code', 'like', "$searchTerm%")
            ->orWhere('name', 'like', "$searchTerm%")
            ->orderBy('created_at', 'desc')->get();

        // Make sure page is always positive
        if ($page < 1) {
            $page = 1;
        }

        $perPage = Settings::displayedBills();

        // Calculate start from
        $startFrom = ($perPage * ($page - 1));

        $sliced = array_slice($results, $startFrom, $perPage);

        $paginate = new LengthAwarePaginator($sliced, count($results), $perPage);

        if (isset($searchTerm) && strlen($searchTerm) > 0) {
            $paginate->setPath('/admin-center/products-manager/get/search');
            $paginate->appends(['term' => $searchTerm]);
        } else {
            $paginate->setPath('/admin-center/products-manager/get');
        }

        return $paginate;
    }

}