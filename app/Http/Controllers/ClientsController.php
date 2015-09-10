<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Client;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\EditClientNameRequest;
use App\Http\Requests\EditClientPhoneRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Handle user clients
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ClientsController extends Controller {

    /**
     * Initialize required stuff
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Render index page
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('clients');
    }

    /**
     * Paginate clients
     *
     * @return mixed
     */
    public function getClients() {
        return Client::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Render client page
     *
     * @param int $clientId
     * @return \Illuminate\View\View
     */
    public function client($clientId) {
        return view('client')->with('clientId', $clientId);
    }

    /**
     * Get client details
     *
     * @param int $clientId
     * @return array
     */
    public function getClient($clientId) {

        $client = Client::where('clients.id', $clientId)
            ->where('clients.user_id', Auth::user()->id)
            ->join('bills', 'clients.id', '=', 'bills.client_id')
            ->select('clients.*', DB::raw('COUNT(bills.id) as total_bills'))
            ->first();

        // Make sure client exists
        if (!$client) {
            return [
                'success' => false,
                'title' => trans('common.error'),
                'message' => trans('clients.client_not_found')
            ];
        }

        $client->bills = Bill::where('client_id', $clientId)
            ->where('user_id', Auth::user()->id)
            ->select('campaign_number', 'campaign_year', 'created_at')
            ->get();

        return [
            'success' => true,
            'data' => $client
        ];

    }


    /**
     * Allow user to edit clients name
     *
     * @param int $clientId
     * @param EditClientNameRequest $request
     * @return array
     */
    public function editName($clientId, EditClientNameRequest $request) {

        Client::where('id', $clientId)->where('user_id', Auth::user()->id)
            ->update(['name' => $request->get('name')]);

        return [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('clients.client_name_updated')
        ];

    }


    /**
     * Allow user to edit clients phone number
     *
     * @param int $clientId
     * @param EditClientPhoneRequest $request
     * @return array
     */
    public function editPhone($clientId, EditClientPhoneRequest $request) {

        Client::where('id', $clientId)->where('user_id', Auth::user()->id)
            ->update(['phone_number' => $request->get('phone')]);

        return [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('clients.client_phone_updated')
        ];

    }


    /**
     * Create a new client
     *
     * @param CreateClientRequest $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function create(CreateClientRequest $request) {

        // Check if client already exists
        if (DB::table('clients')->where('name', $request->get('name'))->where('user_id', Auth::user()->id)->count()) {
            $response = [
                'success' => false,
                'title' => trans('common.fail'),
                'message' => trans('clients.client_exists')
            ];

            return response($response, 200);
        }

        // Create client array
        $clientData = [
            'name' => $request->get('name'),
            'user_id' => Auth::user()->id
        ];

        $client = new Client();
        $client->name = $clientData['name'];
        $client->user_id = $clientData['user_id'];

        // Check if a phone number was given
        if ($request->get('phone')) {
            $client->phone_number = $request->get('phone');
        }

        $client->save();

        // Return success message
        return [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('clients.client_added')
        ];

    }

    /**
     * Delete client
     *
     * @param int $clientId
     * @return array
     */
    public function delete($clientId) {

        $table = 'clients';

        // Count rows, delete record and count rows after the operation
        $initialRows = DB::table($table)->where('user_id', Auth::user()->id)->count();
        DB::table($table)->where('id', $clientId)->where('user_id', Auth::user()->id)->delete();
        $finalRows = DB::table($table)->where('user_id', Auth::user()->id)->count();

        // Check if record was deleted or not and return a success or error response
        if ($finalRows < $initialRows) {
            return [
                'success' => true,
                'title' => trans('common.success'),
                'message' => trans('clients.client_deleted')
            ];
        }

        return [
            'success' => false,
            'title' => trans('common.fail'),
            'message' => trans('common.delete_error')
        ];

    }

}