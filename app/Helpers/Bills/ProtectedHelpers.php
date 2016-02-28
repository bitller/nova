<?php

namespace App\Helpers\Bills;
use App\Bill;
use App\Client;
use App\Helpers\Settings;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Contains protected methods that should be used only inside Bills helper, not somewhere else.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProtectedHelpers {

    /**
     * Return an array that contains only client ids extracted from given query result.
     *
     * @param array $query Query builder result.
     * @return array
     */
    protected static function getClientIdsFromQueryResults($query) {

        $clientIds = [];

        foreach ($query as $result) {
            $clientIds[] = $result->id;
        }

        return $clientIds;
    }

    /**
     * Add missing optional fields in given $config array used in bills pagination query.
     *
     * @param array $config
     */
    protected static function inspectGetConfigAndAddDefaultValuesToMissingOptions(&$config) {

        // Default config values
        $defaults = [
            'onlyPaidBills' => false,
            'userId' => Auth::user()->id,
            'page' => 1,
            'searchTerm' => false
        ];

        foreach ($defaults as $key => $value) {
            if (!isset($config[$key])) {
                $config[$key] = $value;
            }
        }
    }

    /**
     * Do get client ids query and return them in an array.
     *
     * @param array $config Returned by inspectGetConfigAndAddDefaultValuesToMissingOptions method
     * @return array
     */
    protected static function performGetClientIdsQuery($config) {

        $clientIdsQuery = Client::select('id')->where('clients.user_id', $config['userId']);

        // Check if search term is given
        if (isset($config['searchTerm']) && strlen($config['searchTerm']) > 0) {
            $clientIdsQuery = $clientIdsQuery->where('clients.name', 'like', $config['searchTerm'].'%')->get();
        } else {
            $clientIdsQuery = $clientIdsQuery->get();
        }

        // Build an array that contains only clint ids
        $clientIds = [];

        foreach ($clientIdsQuery as $result) {
            $clientIds[] = $result->id;
        }

        return $clientIds;
    }

    /**
     * Return array with bill ids and question marks to be used in prepared sql statement.
     *
     * @param array $config
     * @param array $clientIds
     * @return mixed
     */
    protected static function performGetBillDataQuery($config, $clientIds) {

        $billIdsQuery = Bill::where('paid', $config['onlyPaidBills'])->whereIn('client_id', $clientIds)->get();

        // Build string with question marks and remove last comma
        $questionMarks = '';
        foreach ($billIdsQuery as $result) {
            $questionMarks .= '?,';
        }
        $questionMarks = substr($questionMarks, 0, -1);

        // Build array with values
        $billIds = [];
        $stop = 2;
        for ($i = 1; $i <= $stop; $i++) {
            foreach ($billIdsQuery as $result) {
                $billIds[] = $result->id;
            }
        }

        return [
            'billIds' => $billIds,
            'questionMarks' => $questionMarks
        ];
    }

    protected static function performBillsPaginationQuery($config, $questionMarks, $billIds) {

        // Build query
        $query = "SELECT SUM(bills.final_price) AS final_price, SUM(bills.quantity) AS number_of_products, bills.id, bills.client_name, bills.campaign_order, bills.campaign_year, bills.campaign_number, bills.payment_term, bills.created_at FROM ";
        $query .= "(SELECT bill_products.final_price AS final_price, bill_products.quantity, bills.id, clients.name AS client_name, bills.campaign_order, ";
        $query .= "campaigns.year AS campaign_year, campaigns.number AS campaign_number, bills.payment_term, bills.created_at ";
        $query .= "FROM bills LEFT JOIN bill_products ON bill_products.bill_id = bills.id ";
        // Join campaigns
        $query .= "LEFT JOIN campaigns ON bills.campaign_id = campaigns.id ";
        // Join clients table
        $query .= "LEFT JOIN clients ON clients.id = bills.client_id WHERE bills.id IN ($questionMarks) ";
        $query .= "UNION ALL SELECT bill_application_products.final_price as final_price, bill_application_products.quantity as quantity, bills.id, ";
        $query .= "clients.name as client_name, bills.campaign_order, campaigns.year as campaign_year, campaigns.number as campaign_number, bills.payment_term, bills.created_at FROM bills ";
        // Join bill application products table
        $query .= "LEFT JOIN bill_application_products ON bill_application_products.bill_id = bills.id ";
        // Join campaigns table
        $query .= "LEFT JOIN campaigns ON campaigns.id = bills.campaign_id ";
        // Join clients table
        $query .= "LEFT JOIN clients ON clients.id = bills.client_id ";
        $query .= "WHERE bills.id IN ($questionMarks) AND clients.name=bills.id) bills ";
        $query .= "GROUP BY bills.id ORDER BY bills.created_at DESC";

        // Execute query
        $results = DB::select($query, $billIds);

        // Make sure page is always positive
        if ($config['page'] < 1) {
            $config['page'] = 1;
        }

        $perPage = Settings::displayedBills();

        // Calculate start from
        $startFrom = ($perPage * ($config['page'] - 1));

        $sliced = array_slice($results, $startFrom, $perPage);

        $paginate = new LengthAwarePaginator($sliced, count($results), $perPage);

        if (isset($config['searchTerm']) && strlen($config['searchTerm']) > 0) {
            $paginate->setPath('/bills/get/search');
            $paginate->appends(['term' => $config['searchTerm']]);
        } else {
            $paginate->setPath('/bills/get');
        }

        return $paginate;
    }
}