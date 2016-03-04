<?php

namespace App\Helpers\Paginators;

use App\Helpers\Paginators\BasePaginator;
use App\Helpers\Settings;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Paginate application products search results.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateApplicationProductsSearchResults extends BasePaginator {

    /**
     * Paginate search term results.
     *
     * @param string $searchTerm
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function get($searchTerm, $page) {
        return self::paginate($searchTerm, $page);
    }

    /**
     * Return pagination results for given $searchTerm and $page.
     *
     * @param string $searchTerm
     * @param int $page
     * @return LengthAwarePaginator
     */
    protected static function paginate($searchTerm, $page) {

        // Run query to get results
        $query = \DB::table('application_products')
            ->where('code', 'like', "$searchTerm%")
            ->orWhere('name', 'like', "$searchTerm%")
            ->orderBy('code', 'asc')
            ->get();

        // Make sure page is always positive
        self::validatePage($page);

        $perPage = Settings::displayedBills();

        // Calculate start from
        $startFrom = self::getStartFrom($page, $perPage);

        // Get sliced results
        $sliced = self::getSlicedResults($query, $startFrom, $perPage);

        // Initialize paginator
        $paginate = new LengthAwarePaginator($sliced, count($query), $perPage);

        // Check if search term should be appended to search path
        if (isset($searchTerm) && strlen($searchTerm) > 0) {
            $paginate->setPath('/products/get/search');
            $paginate->appends(['term' => $searchTerm]);
        } else {
            $paginate->setPath('/products/get');
        }

        return $paginate;
    }
}