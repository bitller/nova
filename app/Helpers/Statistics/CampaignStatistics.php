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

    public static function all($campaignNumber, $campaignYear) {
        return [
            'total_bills_price' => self::totalBillsPrice($campaignNumber, $campaignYear),
            'number_of_clients' => self::numberOfClients($campaignNumber, $campaignYear),
            'number_of_bills' => self::numberOfBills($campaignNumber, $campaignYear),
            'number_of_cashed_bills' => self::numberOfCashedBills($campaignNumber, $campaignYear),
            'number_of_bills_with_passed_payment_term' => self::numberOfBillsWithPassedPaymentTerm($campaignNumber, $campaignYear),
        ];
    }

    /**
     * Return total bills price for given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function totalBillsPrice($campaignNumber, $campaignYear) {

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
        $query = "SELECT SUM(bills.final_price) as total_bills_price FROM (SELECT bill_products.final_price FROM bill_products ";
        $query .= "WHERE bill_products.bill_id IN($questionMarks)";
        $query .= "UNION ALL SELECT bill_application_products.final_price FROM bill_application_products ";
        $query .= "WHERE bill_application_products.bill_id IN($questionMarks)) bills";

        $result = DB::select($query, $billIds);

        if (isset($result[0]->total_bills_price)) {
            return $result[0]->total_bills_price;
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
        $result = Campaign::select(DB::raw('COUNT(clients.id) as number_of_clients'))
            ->leftJoin('bills', 'bills.campaign_id', '=', 'campaigns.id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('campaigns.number', $campaignNumber)
            ->where('campaigns.year', $campaignYear)
            ->groupBy('clients.id')
            ->get();

        if (isset($result[0]->number_of_clients)) {
            return $result[0]->number_of_clients;
        }

        return 0;
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
            ->where('campaigns.number', $campaignNumber)
            ->where('campaigns.year', $campaignYear)
            ->get();

        // Make sure result was returned
        if (isset($result[0]->number_of_bills)) {
            return $result[0]->number_of_bills;
        }

        return 0;
    }

    public static function totalDiscount() {
        //
    }

    public static function numberOfProducts() {
        //
    }

    /**
     * Return number of cahsed bills in given campaign.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @return int
     */
    public static function numberOfCashedBills($campaignNumber, $campaignYear) {

        $result = Campaign::select(DB::raw('COUNT(bills.id) as number_of_cashed_bills'))
            ->leftJoin('bills', 'bills.campaign_id', '=', 'campaigns.id')
            ->where('campaigns.number', $campaignNumber)
            ->where('campaigns.year', $campaignYear)
            ->get();

        if (isset($result[0]->number_of_cashed_bills)) {
            return $result[0]->number_of_cashed_bills;
        }

        return 0;
    }

    public static function cashedMoney($campaignNumber, $campaignYear) {
        //
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
            ->where('campaigns.number', $campaignNumber)
            ->where('campaigns.year', $campaignYear)
            ->where('bills.payment_term', '>', date('Y-m-d'))
            ->get();

        if (isset($result[0]->number_of_bills_with_passed_payment_term)) {
            return $result[0]->number_of_bills_with_passed_payment_term;
        }

        return 0;
    }

    public static function moneyToReceive() {
        //
    }

}