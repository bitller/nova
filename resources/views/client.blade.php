@extends('layout')
@section('content')
    @include('includes.ajax-translations.client')
    <div id="client">
        <div class="container" v-show="loaded">

            <!-- BEGIN Edit client details -->
            <div class="row edit-client-details">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">{{ trans('clients.client_name') }}:</label>
                        <input type="text" class="form-control" id="name" v-model="name">
                    </div>
                    <button class="btn btn-primary" v-on="click: saveName()"><span class="glyphicon glyphicon-floppy-disk"></span> {{ trans('clients.save_client_name') }}</button>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">{{ trans('clients.phone_number') }}:</label>
                        <input type="text" class="form-control" id="phone" v-model="phone">
                    </div>
                    <button class="btn btn-primary" v-on="click: savePhone()"><span class="glyphicon glyphicon-floppy-disk"></span> {{ trans('clients.save_client_phone_number') }}</button>
                </div>
            </div>
            <!-- END Edit client details -->

            <div class="divider"></div>

            <!-- BEGIN Client statistics -->
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item active"><span class="glyphicon glyphicon-stats"></span> {{ trans('clients.client_statistics') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ client.created_at }}</span> {{ trans('clients.client_since') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ client.total_bills }}</span> {{ trans('clients.number_of_orders') }}</li>
                    {{--<li class="list-group-item"><span class="badge">18</span> {{ trans('clients.purchased_products') }}</li>--}}
                    <li class="list-group-item"><span class="badge">@{{ client.total_price }} ron</span> {{ trans('clients.sales_made') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ client.total_discount }} ron</span> {{ trans('clients.received_discount') }}</li>
                </ul>
            </div>
            <!-- END Client statistics -->

            <!-- BEGIN Client bills -->
            <div class="row client-bills" v-show="client.total_bills > 0">
                <h4>{{ trans('clients.bills_of_this_client') }}</h4>
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ trans('bills.client') }}</th>
                            <th>{{ trans('bills.number_of_products') }}</th>
                            <th>{{ trans('bills.campaign') }}</th>
                            <th>{{ trans('bills.created_at') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-repeat="bill in client.bills">
                            <td><a href="#">@{{ client.name }}</a></td>
                            <td>0</td>
                            <td>@{{ bill.campaign_number }}</td>
                            <td>@{{ bill.created_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Client bills -->

        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/client.js"></script>
@endsection