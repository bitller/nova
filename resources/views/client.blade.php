@extends('layout')
@section('content')
    @include('includes.ajax-translations.client')
    <div id="client" client-id="{{ $clientId }}">
        <div class="container" v-show="loaded">

            <div class="add-client-button">
                <span class="my-clients-title">
                    <span v-on="click: resetEditClientNameModal" data-target="#edit-client-name-modal" data-toggle="modal">@{{ name }}</span>
                    <span v-show="email" data-target="#edit-client-email-modal" data-toggle="modal"> - <span>@{{ email }}</span></span>
                    <span v-show="phone_number" data-target="#edit-client-phone-number-modal" data-toggle="modal"> (@{{ phone_number }})</span>
                </span>
                @include('includes.admin-center.buttons.more-options-dropdown', [
                'class' => 'pull-right',
                'text' => trans('common.options'),
                'items' => [
                    [
                        'url' => '#',
                        'name' => trans('clients.edit_client_name'),
                        'icon' => 'glyphicon-user',
                        'data_toggle' => 'modal',
                        'data_target' => '#edit-client-name-modal',
                        'on_click' => 'resetEditClientNameModal'
                    ],
                    [
                        'url' => '#',
                        'name' => trans('clients.edit_client_email'),
                        'icon' => 'glyphicon-envelope',
                        'data_toggle' => 'modal',
                        'data_target' => '#edit-client-email-modal',
                        'on_click' => 'resetEditClientEmailModal'
                    ],
                    [
                        'url' => '#',
                        'name' => trans('clients.edit_client_phone_number'),
                        'icon' => 'glyphicon-phone',
                        'data_toggle' => 'modal',
                        'data_target' => '#edit-client-phone-number-modal',
                        'on_click' => 'resetEditClientPhoneNumberModal'
                    ],
                    [
                        'url' => '#',
                        'name' => trans('clients.delete_client'),
                        'icon' => 'glyphicon-trash',
                        'on_click' => 'deleteClient'
                    ]
                ]
                ])
            </div>

            <div class="alert alert-danger">
                Acest client are patru facturi cu termenul de plata depasit, cu o valoare totala de 30 ron.
            </div>
            <div class="alert alert-success">
                Acest client are de platit 3 facturi cu o valoare totala de 300 ron, ultimul termen de plata fiind 20.02.2016
            </div>

            <ul class="list-group">
                <!-- BEGIN Title -->
                <li class="list-group-item active">
                    <span class="glyphicon glyphicon-stats"></span> {{ trans('clients.client_statistics') }}
                </li>
                <!-- END Title -->

                <!-- BEGIN Money generated by this client -->
                <li class="list-group-item">
                    <span class="badge">129 ron</span> {{ trans('clients.money_generated_by_this_client') }}
                </li>
                <!-- END Money generated by this client -->

                <!-- BEGIN Money generated by the client in this campaign -->
                <li class="list-group-item">
                    <span class="badge">29 ron</span> {{ trans('clients.money_generated_in_this_campaign') }}
                </li>
                <!-- END Money generated by the client in this campaign -->

                <!-- BEGIN Money you need to receive from this client -->
                <li class="list-group-item">
                    <span class="badge">29 ron</span> {{ trans('clients.money_you_have_to_receive_from_this_client') }}
                </li>
                <!-- END You need to receive from this client -->

                <!-- BEGIN Total number of products ordered -->
                <li class="list-group-item">
                    <span class="badge">15</span> {{ trans('clients.total_number_of_products_ordered') }}
                </li>
                <!-- END Total number of products ordered -->

                <!-- BEGIN Number of unique products ordered -->
                <li class="list-group-item">
                    <span class="badge">7</span> {{ trans('clients.number_of_unique_products_ordered') }}
                </li>
                <!-- END Number of unique products ordered -->

                <!-- BEGIN Total discount received by this client -->
                <li class="list-group-item">
                    <span class="badge">69323 ron</span> {{ trans('clients.total_discount_received') }}
                </li>
                <!-- END Total discount received by this client -->

            </ul>

            <!-- BEGIN Last unpaid bills of this user -->
            <div>
                <h4>{{ trans('clients.last_unpaid_bills', ['number' => 4]) }}</h4>
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('clients.number_of_products') }}</th>
                                <th class="text-center">{{ trans('clients.payment_term') }}</th>
                                <th class="text-center">{{ trans('clients.price') }}</th>
                                <th class="text-center">{{ trans('clients.order_number') }}</th>
                                <th class="text-center">{{ trans('clients.campaign') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Last unpaid bills of this user -->

            <!-- BEGIN Last paid bills of this user -->
            <div>
                <h4>{{ trans('clients.last_paid_bills', ['number' => 5]) }}</h4>
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">{{ trans('clients.number_of_products') }}</th>
                            <th class="text-center">{{ trans('clients.payment_term') }}</th>
                            <th class="text-center">{{ trans('clients.price') }}</th>
                            <th class="text-center">{{ trans('clients.order_number') }}</th>
                            <th class="text-center">{{ trans('clients.campaign') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Last paid bills of this user -->

            {{--<!-- BEGIN Client bills -->--}}
            {{--<div class="client-bills" v-show="client.total_bills > 0">--}}
                {{--<h4>{{ trans('clients.bills_of_this_client') }}</h4>--}}
                {{--<div class="panel panel-default">--}}
                    {{--<table class="table table-bordered">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th>{{ trans('bills.client') }}</th>--}}
                            {{--<th>{{ trans('bills.number_of_products') }}</th>--}}
                            {{--<th>{{ trans('bills.campaign') }}</th>--}}
                            {{--<th>{{ trans('bills.created_at') }}</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr v-repeat="bill in client.bills">--}}
                            {{--<td><a href="#">@{{ client.name }}</a></td>--}}
                            {{--<td>0</td>--}}
                            {{--<td>@{{ bill.campaign_number }}</td>--}}
                            {{--<td>@{{ bill.created_at }}</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- END Client bills -->--}}
            @include('includes.modals.edit-client-name')
            @include('includes.modals.edit-client-email')
            @include('includes.modals.edit-client-phone-number')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/client.js"></script>
@endsection