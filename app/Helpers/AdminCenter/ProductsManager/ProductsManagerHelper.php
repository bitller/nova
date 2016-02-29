<?php

namespace App\Helpers\AdminCenter\ProductsManager;

/**
 * Helper methods for products manager section.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductsManagerHelper extends ProtectedHelpers {

    /**
     * Return pagination of searched bills.
     *
     * @param string $searchTerm
     * @param int $page
     * @return mixed
     */
    public static function searchedBillsPagination($searchTerm, $page) {
        return self::paginateSearchedProducts($searchTerm, $page);
    }

}