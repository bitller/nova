<?php

namespace App\Helpers\AdminCenter\ProductsManager;
use App\ApplicationProduct;
use App\Helpers\Settings;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Protected hlper methods to be used only inside products manager helpers.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProtectedHelpers {

    /**
     * Paginate searched products.
     *
     * @param string $searchTerm
     * @param int $page
     * @return LengthAwarePaginator
     */
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

    protected static function addNewProduct($data) {

        // Check if product is used by some user and alert those users about the change
        $userIds = self::checkIfProductIsUsedByUsers($data['code']);

        if (count($userIds)) {
            // Product is used, update current product code
        }

        // Product is used, alert users about the change
    }

    /**
     * Check if given $code is used by some user. If is used, ids of that users will be returned, otherwise false.
     *
     * @param string $code
     * @return array|bool
     */
    private static function checkIfProductIsUsedByUsers($code) {

        $query = DB::table('products')->where('code', $code)->get();

        // Product is not used
        if (!count($query)) {
            return false;
        }

        // Product is used, return an array with all user ids
        $userIds = [];
        foreach ($query as $result) {
            $userIds[] = $result->user_id;
        }

        return $userIds;
    }
}