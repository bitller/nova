<?php

namespace App\Helpers\Statistics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Traits\CapsuleManagerTrait;

/**
 * Work with data to compare campaigns statistics.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CompareCampaignsStatistics {

    /**
     * Return all comparison statistics.
     *
     * @param array $campaign
     * @param array $campaignToCompare
     * @return array
     */
    public static function all($campaign, $campaignToCompare) {

        return [
            'details_about_sales' => self::detailsAboutSales($campaign, $campaignToCompare),
            'details_about_number_of_clients' => self::detailsAboutNumberOfClients($campaign, $campaignToCompare),
            'details_about_number_of_bills' => self::detailsAboutNumberOfBills($campaign, $campaignToCompare),
            'details_about_offered_discount' => self::offeredDiscountDetails($campaign, $campaignToCompare),
            'details_about_sold_products' => self::soldProductsDetails($campaign, $campaignToCompare)
        ];

    }

    /**
     * Return details about sales after two campaigns are compared.
     *
     * @param array $campaign
     * @param array $campaignToCompare
     * @return array
     */
    public static function detailsAboutSales($campaign, $campaignToCompare) {

        $campaignSales = CampaignStatistics::totalBillsPrice($campaign['number'], $campaign['year']);
        $campaignToCompareSales = CampaignStatistics::totalBillsPrice($campaignToCompare['number'], $campaignToCompare['year']);

        $translationData = [
            'campaign_number' => $campaign['number'],
            'campaign_year' => $campaign['year'],
            'sales' => $campaignSales,
            'other_campaign_number' => $campaignToCompare['number'],
            'other_campaign_year' => $campaignToCompare['year']
        ];

        $baseOutput = [
            'sales' => $campaignSales,
            'sales_in_campaign_to_compare' => $campaignToCompareSales,
            'sales_label' => trans('statistics.details_about_sales_label', ['campaign_number' => $campaign['number'], 'campaign_year' => $campaign['year']]),
            'sales_in_campaign_to_compare_label' => trans('statistics.details_about_sales_label', ['campaign_number' => $campaignToCompare['number'], 'campaign_year' => $campaignToCompare['year']])
        ];

        // Handle case when both campaigns have no sales
        if ($campaignSales <= 0 && $campaignToCompareSales <= 0) {

            $output = [
                'message' => trans('statistics.details_about_sales_equal_trend', $translationData),
                'title' => trans('statistics.details_about_sales_equal_trend_title'),
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when only first campaign have sales
        if ($campaignSales > 0 && $campaignToCompareSales <= 0) {

            $translationData['plus'] = $campaignSales;

            $output = [
                'message' => trans('statistics.details_about_sales_up_trend', $translationData),
                'title' => trans('statistics.details_about_sales_up_trend_title', ['percent' => 100]),
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when only campaign to compare have sales
        if ($campaignSales <= 0 && $campaignToCompareSales > 0) {

            $translationData['minus'] = $campaignToCompareSales;

            $output = [
                'message' => trans('statistics.details_about_sales_down_trend', $translationData),
                'title' => trans('statistics.details_about_sales_down_trend_title', ['percent' => 100]),
            ];

            return array_merge($output, $baseOutput);
        }

        // Calculate difference and make sure is always positive
        $difference = number_format($campaignSales - $campaignToCompareSales, 2);
        if ($difference < 0) {
            $difference = number_format($difference * -1, 2);
        }

        $divider = $campaignSales;
        if ($campaignSales < $campaignToCompareSales) {
            $divider = $campaignToCompareSales;
        }

        // Calculate percent
        $percent = number_format(($difference * 100) / $divider, 2);

        // Handle case when first campaign have more sales
        if ($campaignSales > $campaignToCompareSales) {

            $translationData['plus'] = $difference;
            $translationData['sales'] = $campaignSales;

            $output = [
                'message' => trans('statistics.details_about_sales_up_trend', $translationData),
                'title' => trans('statistics.details_about_sales_up_trend_title', ['percent' => $percent]),
            ];

        } else if ($campaignSales < $campaignToCompareSales) {

            $translationData['minus'] = $difference;
            $translationData['sales'] = $campaignSales;

            $output = [
                'message' => trans('statistics.details_about_sales_down_trend', $translationData),
                'title' => trans('statistics.details_about_sales_down_trend_title', ['percent' => $percent]),
            ];

        } else {

            $output = [
                'message' => trans('statistics.details_about_sales_equal_trend', $translationData),
                'title' => trans('statistics.details_about_sales_equal_trend_title', ['percent' => $percent]),
            ];
        }

        return array_merge($output, $baseOutput);
    }

    /**
     * Details about number of clients after comparing given campaigns.
     *
     * @param array $campaign
     * @param array $campaignToCompare
     * @return array
     */
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

        $baseOutput = [
            'number_of_clients' => $campaignClients,
            'number_of_clients_in_campaign_to_compare' => $campaignToCompareClients,
            'number_of_clients_label' => trans('statistics.details_about_number_of_clients_label', [
                'campaign_number' => $campaign['number'],
                'campaign_year' => $campaign['year']
            ]),
            'number_of_clients_in_campaign_to_compare_label' => trans('statistics.details_about_number_of_clients_label',  [
                'campaign_number' => $campaignToCompare['number'],
                'campaign_year' => $campaignToCompare['year']
            ])
        ];

        // Handle case when both campaigns have no clients
        if ($campaignClients <= 0 && $campaignToCompareClients <= 0) {

            $translationData['clients'] = $campaignClients;

            $output = [
                'message' => trans('statistics.details_about_number_of_clients_equal_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_equal_trend_title'),
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when only first campaign have clients who ordered
        if ($campaignClients > 0 && $campaignToCompareClients <= 0) {

            $translationData['clients'] = $campaignClients;
            $translationData['plus'] = $campaignClients;

            $output = [
                'message' => trans('statistics.details_about_number_of_clients_up_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_up_trend_title', ['percent' => 100])
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when only campaign to compare have clients who ordered
        if ($campaignClients <= 0 && $campaignToCompareClients > 0) {

            $translationData['clients'] = $campaignClients;
            $translationData['minus'] = $campaignToCompareClients;

            $output = [
                'message' => trans('statistics.details_about_number_of_clients_down_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_down_trend_title', ['percent' => 100])
            ];

            return array_merge($output, $baseOutput);
        }

        // Calculate difference and make sure is always positive
        $difference = $campaignClients - $campaignToCompareClients;
        if ($difference < 0) {
            $difference *= -1;
        }

        $divider = $campaignClients;
        if ($divider < $campaignToCompareClients) {
            $divider = $campaignToCompareClients;
        }

        $percent = number_format(($difference * 100) / $divider, 2);

        // First campaign have more clients
        if ($campaignClients > $campaignToCompareClients) {

            $translationData['plus'] = $difference;

            $output = [
                'message' => trans('statistics.details_about_number_of_clients_up_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_up_trend_title', ['percent' => $percent]),
            ];
        } else if ($campaignClients < $campaignToCompareClients) {

            $translationData['minus'] = $difference;

            $output = [
                'message' => trans('statistics.details_about_number_of_clients_down_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_down_trend_title', ['percent' => $percent]),
            ];

        } else {
            $output = [
                'message' => trans('statistics.details_about_number_of_clients_equal_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_clients_equal_trend_title'),
            ];
        }

        return array_merge($output, $baseOutput);
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

        $baseOutput = [
            'number_of_bills' => $campaignBills,
            'number_of_bills_in_campaign_to_compare' => $campaignToCompareBills,
            'number_of_bills_label' => trans('statistics.details_about_number_of_bills_label', ['campaign_number' => $campaign['number'], 'campaign_year' => $campaign['year']]),
            'number_of_bills_in_campaign_to_compare_label' => trans('statistics.details_about_number_of_bills_label', ['campaign_number' => $campaignToCompare['number'], 'campaign_year' => $campaignToCompare['year']])
        ];

        // Handle case when both campaigns have no bills
        if ($campaignBills <= 0 && $campaignToCompareBills <= 0) {
            $output = [
                'message' => trans('statistics.details_about_number_of_bills_equal_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_equal_trend_title'),
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when only first campaign contain bills
        if ($campaignBills > 0 && $campaignToCompareBills <= 0) {

            $translationData['plus'] = $campaignBills;

            $output = [
                'message' => trans('statistics.details_about_number_of_bills_up_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_up_trend_title', ['percent' => 100]),
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when only campaign to compare contains bills
        if ($campaignBills <= 0 && $campaignToCompareBills > 0) {

            $translationData['minus'] = $campaignToCompareBills;

            $output = [
                'message' => trans('statistics.details_about_number_of_bills_down_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_down_trend_title', ['percent' => 100])
            ];

            return array_merge($output, $baseOutput);
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
            ];
        } else if ($campaignBills < $campaignToCompareBills) {

            // Handle case when campaign to compare have more bills
            $translationData['minus'] = $difference;

            $output = [
                'message' => trans('statistics.details_about_number_of_bills_down_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_down_trend_title', ['percent' => $percent]),
            ];
        } else {
            $output = [
                'message' => trans('statistics.details_about_number_of_bills_equal_trend', $translationData),
                'title' => trans('statistics.details_about_number_of_bills_equal_trend_title'),
            ];
        }

        return array_merge($output, $baseOutput);
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

        $baseOutput = [
            'discount_offered' => $campaignDiscount,
            'discount_offered_in_campaign_to_compare' => $campaignToCompareDiscount,
            'discount_offered_label' => trans('statistics.offered_discount_label', [
                'campaign_number' => $campaign['number'],
                'campaign_year' => $campaign['year']
            ]),
            'discount_offered_in_campaign_to_compare_label' => trans('statistics.offered_discount_label', [
                'campaign_number' => $campaignToCompare['number'],
                'campaign_year' => $campaignToCompare['year']
            ])
        ];

        // Handle case when there is no discount in both campaigns
        if ($campaignDiscount <= 0 && $campaignToCompareDiscount <= 0) {
            $output = [
                'message' => trans('statistics.offered_discount_equal_trend', $translationData),
                'title' => trans('statistics.offered_discount_equal_trend_title'),
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when is no discount in first campaign
        if ($campaignDiscount <= 0) {

            $translationData['minus'] = $campaignToCompareDiscount;

            $output = [
                'message' => trans('statistics.offered_discount_down_trend', $translationData),
                'title' => trans('statistics.offered_discount_down_trend_title', ['percent' => 100])
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when is no discount in campaign to compare
        if ($campaignToCompareDiscount <= 0) {

            $translationData['plus'] = $campaignDiscount;

            $output = [
                'message' => trans('statistics.offered_discount_up_trend', $translationData),
                'title' => trans('statistics.offered_discount_up_trend_title', ['percent' => 100])
            ];

            return array_merge($output, $baseOutput);
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

        $percent = number_format(($difference * 100) / $divider, 2);

        if ($campaignDiscount > $campaignToCompareDiscount) {

            $translationData['plus'] = $difference;

            $output = [
                'message' => trans('statistics.offered_discount_up_trend', $translationData),
                'title' => trans('statistics.offered_discount_up_trend_title', ['percent' => $percent]),
            ];

        } else if ($campaignDiscount < $campaignToCompareDiscount) {

            $translationData['minus'] = $difference;

            $output = [
                'message' => trans('statistics.offered_discount_down_trend', $translationData),
                'title' => trans('statistics.offered_discount_down_trend_title', ['percent' => $percent]),
            ];

        } else {
            $output = [
                'message' => trans('statistics.offered_discount_equal_trend', $translationData),
                'title' => trans('statistics.offered_discount_equal_trend_title'),
            ];
        }

        return array_merge($output, $baseOutput);
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

        $baseOutput = [
            'products_sold_in_campaign' => $campaignProducts,
            'products_in_campaign_to_compare' => $campaignToCompareProducts,
            'sold_products_label' => trans('statistics.sold_products_label', [
                'campaign_number' => $campaign['number'],
                'campaign_year' => $campaign['year']
            ]),
            'sold_products_in_campaign_to_compare_label' => trans('statistics.sold_products_label', [
                'campaign_number' => $campaignToCompare['number'],
                'campaign_year' => $campaignToCompare['year']
            ])
        ];

        // Handle case when there are no sold products in both campaigns
        if ($campaignProducts < 1 && $campaignToCompareProducts < 1) {
            $output = [
                'message' => trans('statistics.sold_products_equal_trend', $translationData),
                'title' => trans('statistics.sold_products_equal_trend_title')
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when in first campaign are no products
        if ($campaignProducts < 1 && $campaignToCompareProducts > 0) {

            $translationData['minus'] = $campaignToCompareProducts;

            $output = [
                'message' => trans('statistics.sold_products_down_trend', $translationData),
                'title' => trans('statistics.sold_products_down_trend_title', ['percent' => 100])
            ];

            return array_merge($output, $baseOutput);
        }

        // Handle case when in campaign to compare are no products
        if ($campaignProducts > 0 && $campaignToCompareProducts < 1) {

            $translationData['plus'] = $campaignProducts;

            $output = [
                'message' => trans('statistics.sold_products_up_trend', $translationData),
                'title' => trans('statistics.sold_products_up_trend_title', ['percent' => 100])
            ];

            return array_merge($output, $baseOutput);
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
        $percent = number_format(($difference * 100) / $divider, 2);

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
        $output = [
            'message' => trans($translationName, $translationData),
            'title' => trans($titleTranslationName, ['percent' => $percent]),
        ];

        return array_merge($output, $baseOutput);
    }
}