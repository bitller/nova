@extends('layout')
@section('content')
    @include('includes.ajax-translations.common')
    <div id="client-unpaid-bills" class="container" v-show="loaded" client-id="{{ $clientId }}">

        <!-- BEGIN Top part -->
        <div class="add-client-button">
            <span class="my-clients-title">
                <span>{{ trans('clients.unpaid_bills_of')}} {{ $name }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('clients.number_of_unpaid_bills') }}">{{ $totalPaidBills }}</span></span>
            </span>
            <a href="/clients/{{ $clientId }}">
                <button type="button" class="btn btn-default pull-right">
                    <span class="glyphicon glyphicon-arrow-left"></span> {{ trans('clients.go_back') }}
                </button>
            </a>
        </div>
        <!-- END Top part -->

        <!-- BEGIN Paid bills table -->
        <div v-show="data.total > 0">
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
                    <tr v-repeat="unpaid_bill in data.data">
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

            <!-- BEGIN Pagination links -->
            <ul class="pager" v-show="data.total > data.per_page">
                <li v-class="disabled : !data.prev_page_url"><a href="#" v-on="click: getPageData(data.prev_page_url)">{{ trans('common.previous') }}</a></li>
                <li v-class="disabled : !data.next_page_url"><a href="#" v-on="click: getPageData(data.next_page_url)">{{ trans('common.next') }}</a></li>
            </ul>
            <!-- END Pagination links -->

        </div>
        <!-- END Paid bills table -->

    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/client-unpaid-bills.js"></script>
@endsection