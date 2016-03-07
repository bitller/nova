<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Client;
use App\Helpers\AjaxResponse;
use App\Helpers\Clients;
use App\Helpers\Settings;
use App\Helpers\Statistics\ClientStatistics;
use App\Http\Requests\Clients\CreateClientRequest;
use App\Http\Requests\Clients\EditClientEmailRequest;
use App\Http\Requests\Clients\EditClientNameRequest;
use App\Http\Requests\Clients\EditClientPhoneNumberRequest;
use App\Http\Requests\Clients\GetClientPaidBillsRequest;
use App\Http\Requests\Clients\GetClientUnpaidBillsRequest;
use App\Http\Requests\DeleteClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Handle user clients
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ClientsController extends BaseController {

    /**
     * Initialize required stuff
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('clients');
    }

    /**
     * Paginate clients.
     *
     * @return mixed
     */
    public function getClients() {
        return Client::select(DB::raw('clients.*, COUNT(bills.id) as number_of_orders'))
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->where('clients.user_id', Auth::user()->id)
            ->orderBy('clients.created_at', 'desc')
            ->groupBy('clients.id')
            ->paginate(Settings::displayedClients());
    }

    /**
     * Render client page.
     *
     * @param int $clientId
     * @return \Illuminate\View\View
     */
    public function client($clientId) {
        return view('clients.client')->with('clientId', $clientId);
    }

    /**
     * Get client details.
     *
     * @param int $clientId
     * @return array
     */
    public function getClient($clientId) {

        $response = new AjaxResponse();

        // Get client
        $client = Client::where('clients.id', $clientId)
            ->where('clients.user_id', Auth::user()->id)
            ->join('bills', 'clients.id', '=', 'bills.client_id')
            ->select('clients.*', DB::raw('COUNT(bills.id) as total_bills'))
            ->first();

        // Make sure client exists
        if (!$client->id) {
            $response->setFailMessage(trans('clients.client_not_found'));
            $response->addExtraFields(['redirect_to' => url('/clients')]);
            return response($response->get(), $response->getDefaultErrorResponseCode());
        }

        // Get client last unpaid bills
        $client->last_unpaid_bills = Clients::lastUnpaidBills($clientId);

        // Get client last paid bills
        $client->last_paid_bills = Clients::lastPaidBills($clientId);

        // Get client statistics
        $client->statistics = ClientStatistics::all($clientId);

        // Money user has to receive from this client
        $client->money_user_has_to_receive = 0;
        if ($client->statistics['money_user_has_to_receive'] > 0) {
            $client->money_user_has_to_receive = trans('clients.client_has_to_pay', ['sum' => $client->statistics['money_user_has_to_receive']]);
        }

        // Money client owes
        $client->money_owed_due_passed_payment_term = 0;
        if ($client->statistics['money_owed_due_passed_payment_term'] > 0) {
            $client->money_owed_due_passed_payment_term = trans('clients.client_has_to_pay_due_passed_payment_term', ['sum' => $client->statistics['money_owed_due_passed_payment_term']]);
        }

        $response->setSuccessMessage('');
        $response->addExtraFields(['data' => $client]);
        return response($response->get());

    }


    /**
     * Allow user to edit clients name.
     *
     * @param int $clientId
     * @param EditClientNameRequest $request
     * @return array
     */
    public function editName($clientId, EditClientNameRequest $request) {

        $response = new AjaxResponse();

        // Make sure client exists and belongs to current user
        if (!Client::where('id', $clientId)->where('user_id', Auth::user()->id)->count()) {
            $response->setFailMessage(trans('clients.client_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        Client::where('id', $clientId)->where('user_id', Auth::user()->id)
            ->update(['name' => $request->get('client_name')]);

        $response->setSuccessMessage(trans('clients.client_name_updated'));
        return response($response->get());

    }

    /**
     * Edit client email.
     *
     * @param int $clientId
     * @param EditClientEmailRequest $request
     * @return mixed
     */
    public function editEmail($clientId, EditClientEmailRequest $request) {

        $response = new AjaxResponse();

        // Make sure client exists and belongs to current user
        if (!Client::where('id', $clientId)->where('user_id', Auth::user()->id)->count()) {
            $response->setFailMessage(trans('clients.client_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        Client::where('id', $clientId)->where('user_id', Auth::user()->id)->update([
            'email' => $request->get('client_email')
        ]);

        $response->setSuccessMessage(trans('clients.client_email_updated'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow user to edit clients phone number.
     *
     * @param int $clientId
     * @param EditClientPhoneNumberRequest $request
     * @return array
     */
    public function editPhone($clientId, EditClientPhoneNumberRequest $request) {

        $response = new AjaxResponse();

        // Make sure client exists and belongs to current user
        if (!Client::where('id', $clientId)->where('user_id', Auth::user()->id)->count()) {
            $response->setFailMessage(trans('clients.client_not_found'));
            return response($response->get(), 404)->header('Content-Type', 'application/json');
        }

        Client::where('id', $clientId)->where('user_id', Auth::user()->id)
            ->update(['phone_number' => $request->get('client_phone_number')]);

        $response->setSuccessMessage(trans('clients.client_phone_updated'));
        return response($response->get());

    }

    /**
     * Create new client.
     *
     * @param CreateClientRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function create(CreateClientRequest $request) {

        $response = new AjaxResponse();

        // Check if client already exists
        if (DB::table('clients')->where('name', $request->get('name'))->where('user_id', Auth::user()->id)->count()) {

            $response->setFailMessage(trans('clients.client_exists'));
            return response($response->get(), $response->getDefaultErrorResponseCode());
        }

        $client = Client::create([
            'name' => $request->get('client_name'),
            'email' => $request->get('client_email'),
            'phone_number' => $request->get('client_phone_number'),
            'user_id' => Auth::user()->id
        ]);


        $response->setSuccessMessage(trans('clients.client_added'));
        return response($response->get());
    }

    /**
     * Delete client.
     *
     * @param DeleteClientRequest $request
     * @param int $clientId
     * @return array
     */
    public function delete($clientId, DeleteClientRequest $request) {

        $response = new AjaxResponse();
        $table = 'clients';

        // Count rows, delete record and count rows after the operation
        $initialRows = DB::table($table)->where('user_id', Auth::user()->id)->count();
        DB::table($table)->where('id', $clientId)->where('user_id', Auth::user()->id)->delete();
        $finalRows = DB::table($table)->where('user_id', Auth::user()->id)->count();

        // Check if record was deleted or not and return a success or error response
        if ($finalRows < $initialRows) {
            $response->setSuccessMessage(trans('clients.client_deleted'));
            return response($response->get());
        }

        $response->setFailMessage(trans('common.delete_error'));
        return response($response->get(), $response->getDefaultErrorResponseCode());

    }

    /**
     * Render paid bills of given client.
     *
     * @param int $clientId
     * @return $this
     */
    public function paidBillsOfThisClient($clientId) {

        $client = Client::where('id', $clientId)
            ->where('user_id', Auth::user()->id)
            ->first();

        // Make sure client exists
        if (!$client) {
            return redirect('/clients');
        }

        $totalPaidBills = Bill::where('paid', 1)->where('client_id', $clientId)->where('user_id', Auth::user()->id)->count();

        return view('client-paid-bills')->with('clientId', $clientId)->with('name', $client->name)->with('totalPaidBills', $totalPaidBills);
    }

    /**
     * Paginate paid bills of given client.
     *
     * @param int $clientId
     * @param GetClientPaidBillsRequest $request
     * @return mixed
     */
    public function getPaidBillsOfThisClient($clientId, GetClientPaidBillsRequest $request) {
        return Clients::paginatePaidBills($clientId, $request->get('page'));
    }

    /**
     * Render unpaid bills page of given client.
     *
     * @param int $clientId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unpaidBillsOfThisClient($clientId) {

        $client = Client::where('id', $clientId)->where('user_id', Auth::user()->id)->first();

        // Make sure client exists
        if (!$client) {
            return redirect('/clients');
        }

        $totalUnpaidBills = Bill::where('paid', 0)->where('client_id', $clientId)->where('user_id', Auth::user()->id)->count();

        return view('client-unpaid-bills')->with('clientId', $clientId)->with('name', $client->name)->with('totalUnpaidBills', $totalUnpaidBills);
    }

    /**
     * Paginate unpaid bills of given client.
     *
     * @param int $clientId
     * @param GetClientUnpaidBillsRequest $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUnpaidBillsOfThisClient($clientId, GetClientUnpaidBillsRequest $request) {
        return Clients::paginateUnpaidBills($clientId, $request->get('page'));
    }

}