<?php

namespace App\Helpers\Statistics;

/**
 * Work with data to compare campaigns statistics.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CompareCampaignsStatistics {

    /**
     * Return compared statistics about sold products in two given campaigns.
     *
     * @param array $campaign
     * @param array $campaignToCompare
     * @return array
     */
    public static function soldProductsDetails($campaign, $campaignToCompare) {

        // Get number of products for each campaign
        $campaignProducts = CampaignStatistics::numberOfProducts($campaign['number'], $campaign['year']);
        $campaignToCompareProducts = CampaignStatistics::numberOfProducts($campaignToCompare['number'], $campaignToCompare['year']);

        // Base translation data
        $translationData = [
            'campaign_number' => $campaign['number'],
            'campaign_year' =>  $campaign['year'],
            'number' => $campaignProducts,
            'other_campaign_number' => $campaignToCompare['number'],
            'other_campaign_year' => $campaignToCompare['year']
        ];

        // Handle case when there are no sold products in both campaigns
        if ($campaignProducts < 1 && $campaignToCompareProducts < 1) {
            return [
                'message' => trans('statistics.sold_products_equal_trend', $translationData),
                'title' => trans('statistics.sold_products_equal_trend_title'),
                'products_sold_in_campaign' => $campaignProducts,
                'products_in_campaign_to_compare' => $campaignToCompareProducts
            ];
        }

        // Handle case when in first campaign are no products
        if ($campaignProducts < 1 && $campaignToCompareProducts > 0) {

            $translationData['minus'] = $campaignToCompareProducts;

            return [
                'message' => trans('statistics.sold_products_down_trend', $translationData),
                'title' => trans('statistics.sold_products_down_trend_title', ['percent' => 100]),
                'products_sold_in_campaign' => $campaignProducts,
                'products_in_campaign_to_compare' => (string) $campaignToCompareProducts
            ];
        }

        // Handle case when in campaign to compare are no products
        if ($campaignProducts > 0 && $campaignToCompareProducts < 1) {

            $translationData['plus'] = $campaignProducts;

            return [
                'message' => trans('statistics.sold_products_up_trend', $translationData),
                'title' => trans('statistics.sold_products_up_trend_title', ['percent' => 100]),
                'products_sold_in_campaign' => $campaignProducts,
                'products_in_campaign_to_compare' => $campaignToCompareProducts
            ];
        }

        // Calculate difference
        $difference = $campaignProducts - $campaignToCompareProducts;

        // Set the biggest value as divider
        if ($campaignProducts > $campaignToCompareProducts) {
            $divider = $campaignProducts;
        } else if ($campaignToCompareProducts > $campaignProducts) {
            $divider = $campaignToCompareProducts;
        } else {
            $divider = $campaignProducts;
        }

        // No changes, same number of products sold
        if ($difference == 0) {
            $upTrend = 0;

        } else if ($difference < 0) {

            // Make difference positive if is negative
            $difference = $difference * (-1);
            $upTrend = -1;

        } else {
            $upTrend = 1;
        }

        // Now calculate the percentage
        $percent = ($difference * 100) / $divider;

        // Choose right translation
        if ($upTrend > 0) {

            $translationData['plus'] = $difference;
            $translationName = 'statistics.sold_products_up_trend';
            $titleTranslationName = 'statistics.sold_products_up_trend_title';

        } else if ($upTrend < 0) {

            $translationData['minus'] = $difference;
            $translationName = 'statistics.sold_products_down_trend';
            $titleTranslationName = 'statistics.sold_products_down_trend_title';

        } else {
            $translationName = 'statistics.sold_products_equal_trend';
            $titleTranslationName = 'statistics.sold_products_equal_trend_title';
        }

        // Return the response
        return [
            'message' => trans($translationName, $translationData),
            'title' => trans($titleTranslationName, ['percent' => $percent]),
            'products_sold_in_campaign' => $campaignProducts,
            'products_in_campaign_to_compare' => $campaignToCompareProducts
        ];
    }
}