<?php

namespace App\Helpers\Statistics;

use App\Bill;
use App\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Statistics for given campaign.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CampaignStatistics {

    /**
     * Return all statistics for given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return array
     */
    public static function all($campaignNumber, $campaignYear) {

        $stats = [
            'total_bills_price' => self::totalBillsPrice($campaignNumber, $campaignYear),
            'number_of_clients' => self::numberOfClients($campaignNumber, $campaignYear),
            'number_of_bills' => self::numberOfBills($campaignNumber, $campaignYear),
            'number_of_cashed_bills' => self::numberOfCashedBills($campaignNumber, $campaignYear),
            'number_of_bills_with_passed_payment_term' => self::numberOfBillsWithPassedPaymentTerm($campaignNumber, $campaignYear),
            'total_discount' => self::totalDiscount($campaignNumber, $campaignYear),
            'number_of_sold_products' => self::numberOfProducts($campaignNumber, $campaignYear),
            'cashed_money' => self::cashedMoney($campaignNumber, $campaignYear)
        ];

        // Calculate number of day passed
        $campaign = Campaign::where('number', $campaignNumber)->where('year', $campaignYear)->first();
        $campaignStartDate = new \DateTime($campaign->start_date);
        $todayDate = new \DateTime(date('Y-m-d'));

        $numberOfDays = $todayDate->diff($campaignStartDate)->format('%a');
        $numberOfDays++;

        // Calculate products sold per day
        $stats['products_sold_per_day'] = number_format($stats['number_of_sold_products'] / $numberOfDays, 2);

        // Calculate money to receive
        $stats['money_to_receive'] = $stats['total_bills_price'] - $stats['cashed_money'];

        return $stats;
    }

    /**
     * Return total bills price for given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function totalBillsPrice($campaignNumber, $campaignYear) {
        $totalPrices = self::totalBillsPrices($campaignNumber, $campaignYear);
        if (isset($totalPrices->total_bills_price)) {
            return $totalPrices->total_bills_price;
        }
        return 0;
    }

    /**
     * Return total bills price from given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function totalBillsPrices($campaignNumber, $campaignYear) {
        $campaign = Campaign::where('year', $campaignYear)->where('number', $campaignNumber)->first();
        $billIdsQuery = Bill::where('user_id', Auth::user()->id)->where('campaign_id', $campaign->id)->get();
        $billIds = [];
        $questionMarks = '';

        // Build string with question marks
        foreach ($billIdsQuery as $result) {
            $questionMarks .= '?,';
        }

        // Remove last comma
        $questionMarks = substr($questionMarks, 0, -1);

        $stop = 2;
        for ($i = 1; $i <= $stop; $i++) {
            foreach ($billIdsQuery as $result) {
                $billIds[] = $result->id;
            }
        }

        // Build sql query
        $query = "SELECT SUM(bills.final_price) as total_bills_price, SUM(bills.price) as price_without_discount FROM (SELECT bill_products.final_price, bill_products.price FROM bill_products ";
        $query .= "WHERE bill_products.bill_id IN($questionMarks)";
        $query .= "UNION ALL SELECT bill_application_products.final_price, bill_application_products.price FROM bill_application_products ";
        $query .= "WHERE bill_application_products.bill_id IN($questionMarks)) bills";

        $result = DB::select($query, $billIds);

        // Make sure result was returned
        if (isset($result[0])) {
            return $result[0];
        }

        return 0;
    }

    /**
     * Return number of clients who ordered in given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function numberOfClients($campaignNumber, $campaignYear) {

        return Bill::where('campaign_id', Campaign::where('number', $campaignNumber)->where('year', $campaignYear)->first()->id)
            ->where('user_id', Auth::user()->id)
            ->distinct('client_id')
            ->count('client_id');
    }

    /**
     * Return number of bills from given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function numberOfBills($campaignNumber, $campaignYear) {

        $result = Campaign::select(DB::raw('COUNT(bills.id) as number_of_bills'))
            ->leftJoin('bills', 'bills.campaign_id', '=', 'campaigns.id')
            ->leftJoin('users', 'users.id', '=', 'bills.user_id')
            ->where('campaigns.number', $campaignNumber)
            ->where('campaigns.year', $campaignYear)
            ->where('users.id', Auth::user()->id)
            ->get();

        // Make sure result was returned
        if (isset($result[0]->number_of_bills)) {
            return $result[0]->number_of_bills;
        }

        return 0;
    }

    /**
     * Return total discount offered in given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return float|string
     */
    public static function totalDiscount($campaignNumber, $campaignYear) {

        $prices = self::totalBillsPrices($campaignNumber, $campaignYear);

        if (isset($prices->total_bills_price) && isset($prices->price_without_discount)) {
            return number_format($prices->price_without_discount - $prices->total_bills_price, 2);
        }

        return 0.00;
    }

    /**
     * Return number of sold products in given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function numberOfProducts($campaignNumber, $campaignYear) {

        $billIdsQuery = Bill::where('campaign_id', Campaign::where('number', $campaignNumber)->where('year', $campaignYear)->first()->id)
            ->where('user_id', Auth::user()->id)
            ->get();
        $billIds = [];
        $questionMarks = '';

        // Build question marks string
        foreach ($billIdsQuery as $result) {
            $questionMarks .= '?,';
        }

        // Remove last comma
        $questionMarks = substr($questionMarks, 0, -1);

        // Build array with ids
        $stop = 2;
        for ($i = 1; $i <= $stop; $i++) {
            foreach ($billIdsQuery as $result) {
                $billIds[] = $result->id;
            }
        }

        $query = "SELECT SUM(bills.quantity) as number_of_products FROM (SELECT bill_products.quantity FROM bill_products WHERE bill_products.bill_id IN($questionMarks)";
        $query .= "UNION ALL SELECT bill_application_products.quantity FROM bill_application_products WHERE bill_application_products.bill_id IN($questionMarks) ) bills";

        $results = DB::select($query, $billIds);

        if (isset($results[0]->number_of_products)) {
            return $results[0]->number_of_products;
        }

        return 0;
    }

    /**
     * Return number of cashed bills in given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function numberOfCashedBills($campaignNumber, $campaignYear) {

        $result = Campaign::select(DB::raw('COUNT(bills.id) as number_of_cashed_bills'))
            ->leftJoin('bills', 'bills.campaign_id', '=', 'campaigns.id')
            ->leftJoin('users', 'users.id', '=', 'bills.user_id')
            ->where('campaigns.number', $campaignNumber)
            ->where('campaigns.year', $campaignYear)
            ->where('bills.paid', 1)
            ->where('users.id', Auth::user()->id)
            ->get();

        if (isset($result[0]->number_of_cashed_bills)) {
            return $result[0]->number_of_cashed_bills;
        }

        return 0;
    }

    /**
     * Return number of cashed money in given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return float
     */
    public static function cashedMoney($campaignNumber, $campaignYear) {

        $billIdsQuery = Bill::where('user_id', Auth::user()->id)
            ->where('campaign_id', Campaign::where('number', $campaignNumber)->where('year', $campaignYear)->first()->id)
            ->where('paid', 1)
            ->get();

        // Build question marks string
        $questionMarks = '';
        foreach ($billIdsQuery as $result) {
            $questionMarks .= '?,';
        }

        // Remove last comma
        $questionMarks = substr($questionMarks, 0, -1);

        // Build bill ids array
        $billIds = [];
        $stop = 2;
        for ($i = 1; $i <= $stop; $i++) {
            foreach ($billIdsQuery as $result) {
                $billIds[] = $result->id;
            }
        }

        $query = "SELECT SUM(bills.cashed_money) as cashed_money FROM (SELECT bill_products.final_price as cashed_money FROM bill_products WHERE bill_products.bill_id IN ($questionMarks) ";
        $query .= "UNION ALL SELECT bill_application_products.final_price as cashed_money FROM bill_application_products WHERE bill_application_products.bill_id IN ($questionMarks)) bills";

        $result = DB::select($query, $billIds);

        // Make sure result was returned
        if (isset($result[0]->cashed_money)) {
            return $result[0]->cashed_money;
        }

        return 0.00;
    }

    /**
     * Return number of bills with passed payment term for given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function numberOfBillsWithPassedPaymentTerm($campaignNumber, $campaignYear) {

        $result = Campaign::select(DB::raw('COUNT(bills.id) as number_of_bills_with_passed_payment_term'))
            ->leftJoin('bills', 'bills.campaign_id', '=', 'campaigns.id')
            ->leftJoin('users', 'users.id', '=', 'bills.user_id')
            ->where('campaigns.number', $campaignNumber)
            ->where('campaigns.year', $campaignYear)
            ->where('bills.paid', 0)
            ->where('bills.payment_term', '<', date('Y-m-d'))
            ->where('users.id', Auth::user()->id)
            ->get();

        if (isset($result[0]->number_of_bills_with_passed_payment_term)) {
            return $result[0]->number_of_bills_with_passed_payment_term;
        }

        return 0;
    }
}