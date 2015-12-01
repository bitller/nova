<?php

namespace App\Helpers\AdminCenter;

use App\HelpCenterArticle;
use App\HelpCenterCategory;

/**
 * Helper functions for help center section.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class HelpCenterManagerHelper {

    public static function getHelpCenterCategoriesAndArticles() {

        $categories = self::getHelpCenterCategories();

        foreach ($categories as &$category) {
            $category->articles = self::getCategoryArticles($category->id);
        }

        return $categories;
    }

    /**
     * Return an array with help center categories.
     *
     * @return array
     */
    public static function getHelpCenterCategories() {

        $helpCenterCategories = [];
        $results = HelpCenterCategory::all();

        foreach ($results as $result) {
            $result->articles = HelpCenterArticle::where('category_id', $result->id)->get();
            $result->number_of_articles = HelpCenterArticle::where('category_id', $result->id)->count();
            $helpCenterCategories[] = $result;
        }

        return $helpCenterCategories;
    }

    /**
     * Return category articles.
     *
     * @param int $categoryId
     * @return array
     */
    public static function getCategoryArticles($categoryId) {

        $categoryArticles = [];
        $results = HelpCenterArticle::where('category_id', $categoryId)->get();

        foreach ($results as $result) {
            $categoryArticles[] = $result;
        }

        return $categoryArticles;
    }

}