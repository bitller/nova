<?php

namespace App\Helpers\Statistics;

use App\Bill;
use App\Campaign;
use App\Helpers\Campaigns;
use Illuminate\Support\Facades\DB;

/**
 * Handle client statistics.
 *
 * @author Alexandru Bugairin <alexandru.bugarin@gmail.com>
 */
class ClientStatistics {

    /**
     * Return all client statistics.
     *
     * @param int $clientId
     * @return array
     */
    public static function all($clientId) {
        return [
            'earnings' => self::earnings($clientId),
            'earnings_in_current_campaign' => self::earningsInCurrentCampaign($clientId),
            'earnings_in_current_year' => self::earningsInCurrentYear($clientId),
            'money_user_has_to_receive' => self::moneyUserHasToReceive($clientId),
            'money_owed_due_passed_payment_term' => self::moneyOwedDuePassedPaymentTerm($clientId),
            'number_of_products_ordered' => self::totalNumberOfProductsOrdered($clientId),
            'number_of_products_ordered_this_year' => self::totalNumberOfProductsOrdered($clientId, true),
            'total_discount_received' => self::totalDiscountReceived($clientId)
        ];
    }

    /**
     * Return earnings made by given client.
     *
     * @param int $clientId
     * @return mixed
     */
    public static function earnings($clientId) {

        // Make first query. I used two separate queries because only one query returns the earnings doubled and I don't have time to solve this by grouping the results
        $billProductsQuery = self::_earningsProductsQuery($clientId);

        // Do the second query
        $billApplicationProductsQuery = self::_earningsApplicationProductsQuery($clientId);

        $earnings = 0;

        // Sum earnings of the two queries
        if (isset($billProductsQuery[0]->earnings)) {
            $earnings += $billProductsQuery[0]->earnings;
        }

        if (isset($billApplicationProductsQuery[0]->earnings)) {
            $earnings += $billApplicationProductsQuery[0]->earnings;
        }

        return number_format($earnings, 2);
    }

    /**
     * @param int $clientId
     * @return int
     */
    public static function earningsInCurrentCampaign($clientId) {

        $earningsInCurrentCampaign = 0;

        $currentCampaignId = Campaigns::current()->id;

        // Query the two tables
        $billProductsQuery = self::_earningsProductsQuery($clientId, ['bills.campaign_id' => $currentCampaignId]);
        $billApplicationsQuery = self::_earningsApplicationProductsQuery($clientId, ['bills.campaign_id' => $currentCampaignId]);

        // Check if first query returned something and add to existent value
        if (isset($billProductsQuery[0]->earnings)) {
            $earningsInCurrentCampaign += $billProductsQuery[0]->earnings;
        }

        // Same here for the other table
        if (isset($billApplicationsQuery[0]->earnings)) {
            $earningsInCurrentCampaign += $billApplicationsQuery[0]->earnings;
        }

        return number_format($earningsInCurrentCampaign, 2);
    }

    /**
     * Return how much money generated the given client in current year.
     *
     * @param int $clientId
     * @return string
     */
    public static function earningsInCurrentYear($clientId) {

        $earningsInCurrentYear = 0;
        $whereCondition = ['campaigns.year' => Campaigns::current()->year];

        // Query the two tables
        $billProductsQuery = self::_earningsProductsQuery($clientId, $whereCondition);
        $billApplicationProductsQuery = self::_earningsApplicationProductsQuery($clientId, $whereCondition);

        // Check if first query returned something
        if (isset($billProductsQuery[0]->earnings)) {
            $earningsInCurrentYear += $billProductsQuery[0]->earnings;
        }

        // Now check if second query returned something
        if (isset($billApplicationProductsQuery[0]->earnings)) {
            $earningsInCurrentYear += $billApplicationProductsQuery[0]->earnings;
        }

        return number_format($earningsInCurrentYear, 2);
    }

    /**
     * Return money a user has to receive from given client.
     *
     * @param int $clientId
     * @return int
     */
    public static function moneyUserHasToReceive($clientId) {

        $moneyToReceive = 0;

        // Get only not paid bills
        $paid = 0;

        $query = DB::table('clients')
            ->select(DB::raw('SUM(bill_products.final_price * bill_products.quantity) as earnings'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', $paid)
            ->where('bills.payment_term', '>', date('Y-m-d'))
            ->where('clients.id', $clientId)
            ->groupBy('products.id')
            ->get();

        $secondQuery = DB::table('application_products')
            ->select(DB::raw('SUM(bill_application_products.final_price * bill_application_products.quantity) as earnings'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('bills.paid', $paid)
            ->where('bills.payment_term', '>', date('Y-m-d'))
            ->where('clients.id', $clientId)
            ->groupBy('clients.id')
            ->get();

        if (isset($query[0]->earnings)) {
            $moneyToReceive += $query[0]->earnings;
        }
        if (isset($secondQuery[0]->earnings)) {
            $moneyToReceive += $secondQuery[0]->earnings;
        }

        return $moneyToReceive;
    }

    /**
     * Money that client owes to the user because payment term was passed.
     *
     * @param int $clientId
     * @return int
     */
    public static function moneyOwedDuePassedPaymentTerm($clientId) {

        $billIdsQuery = Bill::where('client_id', $clientId)->where('payment_term', '<', date('Y-m-d'))->where('paid', 0)->get();

        // Check if query returned something
        if (!count($billIdsQuery)) {
            return 0;
        }

        $questionMarks = '';
        // Build question marks string
        foreach ($billIdsQuery as $result) {
            $questionMarks .= '?,';
        }

        // Remove last comma
        $questionMarks = substr($questionMarks, 0, -1);

        // Build array with ids
        $billIds = [];
        $stop = 2;

        for ($i = 1; $i <= $stop; $i++) {
            foreach ($billIdsQuery as $result) {
                $billIds[] = $result->id;
            }
        }

        $query = "SELECT SUM(bill_products.final_price) as total FROM(SELECT final_price, bill_id FROM bill_products WHERE bill_id IN ($questionMarks) ";
        $query .= "UNION ALL SELECT final_price, bill_id FROM bill_application_products WHERE bill_id IN ($questionMarks)) bill_products";

        $result = DB::select($query, $billIds);

        if (isset($result[0]->total)) {
            return $result[0]->total;
        }

        return 0;
    }

    /**
     * Return number of total products ordered by given client.
     *
     * @param int $clientId
     * @param bool $thisYear Indicate if should be counted only products sold in current year
     * @return mixed
     */
    public static function totalNumberOfProductsOrdered($clientId, $thisYear = false) {

        // Count number of bill products
        $billProducts = DB::table('bill_products')
            ->leftJoin('bills', 'bill_products.bill_id', '=', 'bills.id');

        // Count number of bill application products
        $billApplicationProducts = DB::table('bill_application_products')
            ->leftJoin('bills', 'bill_application_products.bill_id', '=', 'bills.id');

        // Check if should be counted only products sold in this year
        if ($thisYear) {

            $billProducts->leftJoin('campaigns', 'bills.campaign_id', '=', 'campaigns.id')
                ->where('campaigns.year', Campaigns::current()->year);

            $billApplicationProducts->leftJoin('campaigns', 'bills.campaign_id', '=', 'campaigns.id')
                ->where('campaigns.year', Campaigns::current()->year);
        }

        // Continue bill products query
        $billProducts->where('bills.client_id', $clientId)
            ->where('bills.paid', 1);

        // Resume bill application products query
        $billApplicationProducts->where('bills.client_id', $clientId)
            ->where('bills.paid', 1);

        // R
        return $billProducts->sum('bill_products.quantity') + $billApplicationProducts->sum('bill_application_products.quantity');
    }

    /**
     * Return total discount received by given client.
     *
     * @param int $clientId
     * @return int
     */
    public static function totalDiscountReceived($clientId) {

        $totalDiscount = 0;

        // Build query to return total discount received by this client
        $firstQuery = DB::table('clients')
            ->select(DB::raw('SUM((bill_products.price - bill_products.final_price) * bill_products.quantity) as total_discount'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', 1)
            ->where('clients.id', $clientId)
            ->groupBy('products.id')
            ->get();

        $secondQuery = DB::table('application_products')
            ->select(DB::raw('SUM((bill_application_products.price - bill_application_products.final_price) * bill_application_products.quantity) as total_discount'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('bills.paid', 1)
            ->where('clients.id', $clientId)
            ->groupBy('clients.id')
            ->get();

        if (isset($firstQuery[0]->total_discount)) {
            $totalDiscount += $firstQuery[0]->total_discount;
        }
        if (isset($secondQuery[0]->total_discount)) {
            $totalDiscount += $secondQuery[0]->total_discount;
        }

        return $totalDiscount;
    }

    /**
     * @param int $clientId
     * @param array $otherWheres
     * @param bool $paid
     * @return mixed
     */
    private static function _earningsProductsQuery($clientId, $otherWheres = [], $paid = true) {

        if (!$paid) {
            $paid = 0;
        } else {
            $paid = 1;
        }

        $query = DB::table('clients')
            ->select(DB::raw('SUM(bill_products.final_price) as earnings'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('campaigns', 'campaigns.id', '=', 'bills.campaign_id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', $paid)
            ->where('clients.id', $clientId);

        if (count($otherWheres)) {
            foreach ($otherWheres as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->groupBy('products.id')->get();
    }

    /**
     * @param int $clientId
     * @param array $otherWheres
     * @param bool $paid
     * @return
     */
    private static function _earningsApplicationProductsQuery($clientId, $otherWheres = [], $paid = true) {

        if (!$paid) {
            $paid = 0;
        } else {
            $paid = 1;
        }

        $query = DB::table('application_products')
            ->select(DB::raw('SUM(bill_application_products.final_price) as earnings'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('campaigns', 'campaigns.id', '=', 'bills.campaign_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('bills.paid', $paid)
            ->where('clients.id', $clientId);

        // Add extra where conditions, if given
        if ($otherWheres) {
            foreach ($otherWheres as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->groupBy('clients.id')->get();
    }
}