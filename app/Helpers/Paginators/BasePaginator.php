<?php

namespace App\Helpers\Paginators;

/**
 * Common methods used by other paginators.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BasePaginator {

    /**
     * Make sure page is always positive.
     *
     * @param int $page
     */
    protected static function validatePage(&$page) {
        if ($page < 1) {
            $page = 1;
        }
    }

    /**
     * Return start from.
     *
     * @param int $page
     * @param int $perPage
     * @return int
     */
    protected static function getStartFrom($page, $perPage) {
        return ($perPage * ($page - 1));
    }

    /**
     * Return sliced results.
     *
     * @param array $results
     * @param int $startFrom
     * @param int $perPage
     * @return array
     */
    protected static function getSlicedResults($results, $startFrom, $perPage) {
        return array_slice($results, $startFrom, $perPage);
    }
}