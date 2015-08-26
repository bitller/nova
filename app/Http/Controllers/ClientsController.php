<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
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