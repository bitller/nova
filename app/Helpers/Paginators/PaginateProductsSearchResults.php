<?php

namespace App\Helpers\Paginators;

use App\Helpers\Paginators\BasePaginator;
use App\Helpers\Settings;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Paginate products search results.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateProductsSearchResults extends BasePaginator {

    /**
     * Get pagination results.
     *
     * @param string $searchTerm
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function get($searchTerm, $page) {
        return self::paginate($searchTerm, $page);
    }

    /**
     * Perform query and return pagination results.
     *
     * @param string $searchTerm
     * @param int $page
     * @return LengthAwarePaginator
     */
    protected static function paginate($searchTerm, $page) {

        // Query database to get results
        $results = DB::table('products')
            ->where('code', 'like', "$searchTerm%")
            ->orWhere('name', 'like', "$searchTerm%")
            ->orderBy('code', 'asc')
            ->get();

        // Make sure page is always positive
        self::validatePage($searchTerm);

        $perPage = Settings::displayedBills();

        // Calculate start from
        $startFrom = self::getStartFrom($page, $perPage);

        // Slice the results
        $sliced = self::getSlicedResults($results, $startFrom, $perPage);

        // Initialize the paginator
        $paginate = new LengthAwarePaginator($sliced, count($results), $perPage);

        // Check if search term should be appended to the search path
        if (isset($searchTerm) && strlen($searchTerm) > 0) {
            $paginate->setPath('/my-products/get/search');
            $paginate->appends(['term' => $searchTerm]);
        } else {
            $paginate->setPath('/my-products/get');
        }

        return $paginate;
    }
}