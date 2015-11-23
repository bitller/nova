<?php

namespace App\Helpers\AdminCenter;

use App\HelpCenterCategory;

/**
 * Helper functions for help center section.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class HelpCenterManagerHelper {

    /**
     * Return an array with help center categories.
     *
     * @return array
     */
    public static function getHelpCenterCategories() {

        $helpCenterCategories = [];
        $results = HelpCenterCategory::all();

        foreach ($results as $result) {
            $helpCenterCategories[] = $result;
        }

        return $helpCenterCategories;
    }

}