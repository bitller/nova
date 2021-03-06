@extends('layout.index')
@section('content')
    @include('includes.ajax-translations.client')
    <div id="client" client-id="{{ $clientId }}">
        <div class="container" v-show="loaded">

            <div class="add-client-button">
                <span class="my-clients-title">
                    <span class="pointer-underline" v-on="click: resetEditClientNameModal" data-target="#edit-client-name-modal" data-toggle="modal">@{{ name }}</span>
                    <span v-show="email" data-target="#edit-client-email-modal" data-toggle="modal"> - <span class="pointer-underline">@{{ email }}</span></span>
                    <span class="pointer-underline" v-show="phone_number" data-target="#edit-client-phone-number-modal" data-toggle="modal"> (@{{ phone_number }})</span>
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

            <div v-show="money_owed_due_passed_payment_term" class="alert alert-danger">
                @{{ money_owed_due_passed_payment_term }}
            </div>
            <div v-show="money_user_has_to_receive" class="alert alert-success">
                @{{ money_user_has_to_receive }}
            </div>

            <ul class="list-group">
                <!-- BEGIN Title -->
                <li class="list-group-item active">
                    <span class="glyphicon glyphicon-stats primary-color"></span> {{ trans('clients.client_statistics') }}
                </li>
                <!-- END Title -->

                <!-- BEGIN Money generated by this client -->
                <li class="list-group-item">
                    <span class="badge">@{{ statistics.earnings }} ron</span> {{ trans('clients.money_generated_by_this_client') }}
                </li>
                <!-- END Money generated by this client -->

                <!-- BEGIN Money generated by the client in this campaign -->
                <li class="list-group-item">
                    <span class="badge">@{{ statistics.earnings_in_current_campaign }} ron</span> {{ trans('clients.money_generated_in_this_campaign') }}
                </li>
                <!-- END Money generated by the client in this campaign -->

                <!-- BEGIN Money you need to receive from this client -->
                <li class="list-group-item">
                    <span class="badge">@{{ statistics.money_user_has_to_receive }} ron</span> {{ trans('clients.money_you_have_to_receive_from_this_client') }}
                </li>
                <!-- END You need to receive from this client -->

                <!-- BEGIN Total number of products ordered -->
                <li class="list-group-item">
                    <span class="badge">@{{ statistics.number_of_products_ordered }}</span> {{ trans('clients.total_number_of_products_ordered') }}
                </li>
                <!-- END Total number of products ordered -->

                <!-- BEGIN Total discount received by this client -->
                <li class="list-group-item">
                    <span class="badge">@{{ statistics.total_discount_received }} ron</span> {{ trans('clients.total_discount_received') }}
                </li>
                <!-- END Total discount received by this client -->

            </ul>

            <!-- BEGIN Last unpaid bills of this client -->
            <div v-show="last_unpaid_bills">
                <h4>
                    {{ trans('clients.last_unpaid_bills') }}
                    <span>-</span>
                    <a href="/clients/{{ $clientId  }}/bills/unpaid">{{ trans('clients.view_all_unpaid_bills') }}</a>
                </h4>
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('clients.number_of_products') }}</th>
                                <th class="text-center">{{ trans('clients.payment_term') }}</th>
                                <th class="text-center">{{ trans('bills.price') }}</th>
                                <th class="text-center">{{ trans('clients.order_number') }}</th>
                                <th class="text-center">{{ trans('bills.campaign') }}</th>
                                <th class="text-center">{{ trans('clients.access_bill') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-repeat="unpaid_bill in last_unpaid_bills">
                                <td class="text-center vert-align">@{{ unpaid_bill.number_of_products }}</td>
                                <td class="text-center vert-align">@{{ unpaid_bill.payment_term }}</td>
                                <td class="text-center vert-align">@{{ unpaid_bill.total }}</td>
                                <td class="text-center vert-align">@{{ unpaid_bill.campaign_order }}</td>
                                <td class="text-center vert-align">@{{ unpaid_bill.campaign_number }}/@{{ unpaid_bill.campaign_year }}</td>
                                <td class="text-center vert-align"><a href="/bills/@{{ unpaid_bill.bill_id }}"><button class="btn btn-default"><span class="glyphicon glyphicon-arrow-right"></span>&nbsp;{{ trans('clients.access_bill') }}</button></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Last unpaid bills of this client -->

            <!-- BEGIN Last paid bills of this client -->
            <div v-show="last_paid_bills">
                <h4>
                    {{ trans('clients.last_paid_bills') }}
                    <span>-</span>
                    <a href="/clients/{{ $clientId  }}/bills/paid">{{ trans('clients.view_all_paid_bills') }}</a>
                </h4>
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">{{ trans('clients.number_of_products') }}</th>
                            <th class="text-center">{{ trans('clients.payment_term') }}</th>
                            <th class="text-center">{{ trans('bills.price') }}</th>
                            <th class="text-center">{{ trans('clients.order_number') }}</th>
                            <th class="text-center">{{ trans('bills.campaign') }}</th>
                            <th class="text-center">{{ trans('clients.access_bill') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-repeat="paid_bill in last_paid_bills">
                            <td class="text-center vert-align">@{{ paid_bill.number_of_products }}</td>
                            <td class="text-center vert-align">@{{ paid_bill.payment_term }}</td>
                            <td class="text-center vert-align">@{{ paid_bill.total }}</td>
                            <td class="text-center vert-align">@{{ paid_bill.campaign_order }}</td>
                            <td class="text-center vert-align">@{{ paid_bill.campaign_number }}/@{{ paid_bill.campaign_year }}</td>
                            <td class="text-center vert-align"><a href="/bills/@{{ paid_bill.bill_id }}"><button class="btn btn-default"><span class="glyphicon glyphicon-arrow-right"></span>&nbsp;{{ trans('clients.access_bill') }}</button></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Last paid bills of this client -->

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