<?php

namespace App\Helpers\Statistics;
use Illuminate\Support\Facades\Auth;

/**
 * Work with data to compare campaigns statistics.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CompareCampaignsStatistics {

    public static function detailsAboutNumberOfClients($campaign, $campaignToCompare) {

        $campaignClients = CampaignStatistics::numberOfClients($campaign['number'], $campaign['year']);
        $campaignToCompareClients = CampaignStatistics::numberOfClients($campaignToCompare['number'], $campaignToCompare['year']);

        $translationData = [
            'campaign_number' => $campaign['number'],
            'campaign_year' => $campaign['year'],
            'clients' => $campaignClients,
            'other_campaign_number' => $campaignToCompare['number'],
            'other_campaign_year' => $campaignToCompare['year']
        ];

        // Handle case when both campaigns have no clients
        if ($campaignClients <= 0 && $campaignToCompareClients <= 0) {

            $translationData['clients'] = $campaignClients;

            return [
                'message' => trans('statistics.details_about_number_of_clients_equal_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_equal_trend_title'),
                'number_of_clients' => $campaignClients,
                'number_of_clients_in_campaign_to_compare' => $campaignToCompareClients
            ];
        }

        // Handle case when only first campaign have clients who ordered
        if ($campaignClients > 0 && $campaignToCompareClients <= 0) {

            $translationData['clients'] = $campaignClients;
            $translationData['plus'] = $campaignClients;

            return [
                'message' => trans('statistics.details_about_number_of_clients_up_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_up_trend_title', ['percent' => 100]),
                'number_of_clients' => $campaignClients,
                'number_of_clients_in_campaign_to_compare' => $campaignToCompareClients
            ];
        }

        // Handle case when only campaign to compare have clients who ordered
        if ($campaignClients <= 0 && $campaignToCompareClients > 0) {

            $translationData['clients'] = $campaignClients;
            $translationData['minus'] = $campaignToCompareClients;

            return [
                'message' => trans('statistics.details_about_number_of_clients_down_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_down_trend_title', ['percent' => 100]),
                'number_of_clients' => $campaignClients,
                'number_of_clients_in_campaign_to_compare' => $campaignToCompareClients
            ];
        }
    }

    /**
     * Return details about number of bills in given campaigns compared.
     *
     * @param array $campaign
     * @param array $campaignToCompare
     * @return array
     */
    public static function detailsAboutNumberOfBills($campaign, $campaignToCompare) {

        $campaignBills = CampaignStatistics::numberOfBills($campaign['number'], $campaign['year']);
        $campaignToCompareBills = CampaignStatistics::numberOfBills($campaignToCompare['number'], $campaignToCompare['year']);

        $translationData = [
            'campaign_number' => $campaign['number'],
            'campaign_year' => $campaign['year'],
            'bills' => $campaignBills,
            'other_campaign_number' => $campaignToCompare['number'],
            'other_campaign_year' => $campaignToCompare['year']
        ];

        // Handle case when both campaigns have no bills
        if ($campaignBills <= 0 && $campaignToCompareBills <= 0) {
            return [
                'message' => trans('statistics.details_about_number_of_bills_equal_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_equal_trend_title'),
                'number_of_bills' => $campaignBills,
                'number_of_bills_in_campaign_to_compare' => $campaignToCompareBills
            ];
        }

        // Handle case when only first campaign contain bills
        if ($campaignBills > 0 && $campaignToCompareBills <= 0) {

            $translationData['plus'] = $campaignBills;

            return [
                'message' => trans('statistics.details_about_number_of_bills_up_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_up_trend_title', ['percent' => 100]),
                'number_of_bills' => $campaignBills,
                'number_of_bills_in_campaign_to_compare' => $campaignToCompareBills
            ];
        }

        // Handle case when only campaign to compare contains bills
        if ($campaignBills <= 0 && $campaignToCompareBills > 0) {

            $translationData['minus'] = $campaignToCompareBills;

            return [
                'message' => trans('statistics.details_about_number_of_bills_down_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_down_trend_title', ['percent' => 100]),
                'number_of_bills' => $campaignBills,
                'number_of_bills_in_campaign_to_compare' => $campaignToCompareBills
            ];
        }

        // Calculate difference and make sure is always positive
        $difference = $campaignBills - $campaignToCompareBills;
        if ($difference < 0) {
            $difference *= -1;
        }

        $divider = $campaignBills;
        if ($divider < $campaignToCompareBills) {
            $divider = $campaignToCompareBills;
        }

        $percent = number_format(($difference * 100) / $divider, 2);

        // Handle case when first campaign have more bills
        if ($campaignBills > $campaignToCompareBills) {

            $translationData['plus'] = $difference;

            $output = [
                'message' => trans('statistics.details_about_number_of_bills_up_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_up_trend_title', ['percent' => $percent]),
                'number_of_bills' => $campaignBills,
                'number_of_bills_in_campaign_to_compare' => $campaignToCompareBills
            ];
        } else if ($campaignBills < $campaignToCompareBills) {

            // Handle case when campaign to compare have more bills
            $translationData['minus'] = $difference;

            $output = [
                'message' => trans('statistics.details_about_number_of_bills_down_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_down_trend_title', ['percent' => $percent]),
                'number_of_bills' => $campaignBills,
                'number_of_bills_in_campaign_to_compare' => $campaignToCompareBills
            ];
        } else {
            $output = [
                'message' => trans('statistics.details_about_number_of_bills_equal_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_equal_trend_title'),
                'number_of_bills' => $campaignBills,
                'number_of_bills_in_campaign_to_compare' => $campaignToCompareBills
            ];
        }

        return $output;
    }

    /**
     * Return statistics about discount compared in given two campaigns.
     *
     * @param array $campaign
     * @param array $campaignToCompare
     * @return array
     */
    public static function offeredDiscountDetails($campaign, $campaignToCompare) {

        $campaignDiscount = CampaignStatistics::totalDiscount($campaign['number'], $campaign['year']);
        $campaignToCompareDiscount = CampaignStatistics::totalDiscount($campaignToCompare['number'], $campaignToCompare['year']);

        $translationData = [
            'campaign_number' => $campaign['number'],
            'campaign_year' => $campaign['year'],
            'money' => $campaignDiscount,
            'other_campaign_number' => $campaignToCompare['number'],
            'other_campaign_year' => $campaignToCompare['year']
        ];

        // Handle case when there is no discount in both campaigns
        if ($campaignDiscount <= 0 && $campaignToCompareDiscount <= 0) {
            return [
                'message' => trans('statistics.offered_discount_equal_trend', $translationData),
                'title' => trans('statistics.offered_discount_equal_trend_title'),
                'discount_offered' => $campaignDiscount,
                'discount_offered_in_campaign_to_compare' => $campaignToCompareDiscount
            ];
        }

        // Handle case when is no discount in first campaign
        if ($campaignDiscount <= 0) {

            $translationData['minus'] = $campaignToCompareDiscount;

            return [
                'message' => trans('statistics.offered_discount_down_trend', $translationData),
                'title' => trans('statistics.offered_discount_down_trend_title', ['percent' => 100]),
                'discount_offered' => $campaignDiscount,
                'discount_offered_in_campaign_to_compare' => $campaignToCompareDiscount
            ];
        }

        // Handle case when is no discount in campaign to compare
        if ($campaignToCompareDiscount <= 0) {

            $translationData['plus'] = $campaignDiscount;

            return [
                'message' => trans('statistics.offered_discount_up_trend', $translationData),
                'title' => trans('statistics.offered_discount_up_trend_title', ['percent' => 100]),
                'discount_offered' => $campaignDiscount,
                'discount_offered_in_campaign_to_compare' => $campaignToCompareDiscount
            ];
        }

        // Handle case when both campaigns have discount

        // Calculate difference and make sure is positive
        $difference = number_format($campaignDiscount - $campaignToCompareDiscount, 2);
        if ($difference < 0) {
            $difference = number_format($difference * -1, 2);
        }

        // Make sure divider is the biggest number
        $divider = $campaignDiscount;
        if ($campaignDiscount < $campaignToCompareDiscount) {
            $divider = $campaignToCompareDiscount;
        }

        $percent = ($difference * 100) / $divider;

        $output = [];
        if ($campaignDiscount > $campaignToCompareDiscount) {

            $translationData['plus'] = $difference;

            $output = [
                'message' => trans('statistics.offered_discount_up_trend', $translationData),
                'title' => trans('statistics.offered_discount_up_trend_title', ['percent' => $percent]),
                'discount_offered' => $campaignDiscount,
                'discount_offered_in_campaign_to_compare' => $campaignToCompareDiscount
            ];
        } else if ($campaignDiscount < $campaignToCompareDiscount) {

            $translationData['minus'] = $difference;

            $output = [
                'message' => trans('statistics.offered_discount_down_trend', $translationData),
                'title' => trans('statistics.offered_discount_down_trend_title', ['percent' => $percent]),
                'discount_offered' => $campaignDiscount,
                'discount_offered_in_campaign_to_compare' => $campaignToCompareDiscount
            ];
        } else {
            $output = [
                'message' => trans('statistics.offered_discount_equal_trend', $translationData),
                'title' => trans('statistics.offered_discount_equal_trend_title'),
                'discount_offered' => $campaignDiscount,
                'discount_offered_in_campaign_to_compare' => $campaignToCompareDiscount
            ];
        }

        return $output;
    }

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