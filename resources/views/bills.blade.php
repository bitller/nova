@extends('layout')
@section('content')
    <div id="bills">

        @include('includes.ajax-translations.bills')

        <div id="table" v-show="loaded">

            <!-- BEGIN Add bill button -->
            <div class="add-bill-button">
                <span class="my-bills-title">{{ trans('bills.my_bills') }} <span class="badge">@{{ bills.total }}</span></span>
                <button type="button" data-toggle="modal" data-target="#create-bill-modal" v-on="click: resetCreateBillModal()" class="btn btn-primary pull-right">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('bills.create') }}
                </button>
            </div>
            <!-- END Add bill button -->

            <!-- BEGIN No bills info -->
            <div class="alert alert-info no-bills-info" v-show="!bills.total">
                {{ trans('bills.no_bills') }}
            </div>
            <!-- END No bills info -->

            <!-- BEGIN Bills table-->
            <table class="table table-hover" v-show="bills.total">
                <thead>
                <tr>
                    <th><span class="glyphicon glyphicon-user icon-color"></span>&nbsp; {{ trans('bills.client') }}</th>
                    <th><span class="glyphicon glyphicon-tag icon-color"></span>&nbsp; {{ trans('bills.campaign_order') }}</th>
                    <th><span class="glyphicon glyphicon-tags icon-color"></span>&nbsp; {{ trans('bills.campaign') }}</th>
                    <th><span class="glyphicon glyphicon-euro icon-color"></span>&nbsp; {{ trans('bills.price') }}</th>
                    <th><span class="glyphicon glyphicon-calendar icon-color"></span>&nbsp; {{ trans('bills.created_at') }}</th>
                    <th><span class="glyphicon glyphicon-trash icon-color"></span>&nbsp; {{ trans('common.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-repeat="bill in bills.data">
                    <td class="vert-align"><a href="/bills/@{{bill.id}}">@{{ bill.client_name }}</a></td>
                    <td class="vert-align">@{{ bill.campaign_order }}</td>
                    <td class="vert-align">@{{ bill.campaign_number }} {{ trans('bills.from') }} @{{ bill.campaign_year }}</td>
                    <td class="vert-align">@{{ bill.price }} ron</td>
                    <td class="vert-align">@{{ bill.human_date }}</td>
                    <td class="vert-align"><button class="btn btn-danger" v-on="click: deleteBill(bill.id, bills.current_page, bills.to-bills.from,'{{ trans('common.loading') }}')"><span class="glyphicon glyphicon-trash"></span> {{ trans('common.delete') }}</button></td>
                </tr>
                </tbody>
            </table>
            <!-- END Bills table -->

            <!-- BEGIN Pagination links -->
            <ul class="pager" v-show="bills.total > bills.per_page">
                <li v-class="disabled : !bills.prev_page_url"><a href="#" v-on="click: paginate(bills.prev_page_url)">{{ trans('common.previous') }}</a></li>
                <li v-class="disabled : !bills.next_page_url"><a href="#" v-on="click: paginate(bills.next_page_url)">{{ trans('common.next') }}</a></li>
            </ul>
            <!-- END Pagination links -->

        </div>

        @include('includes.modals.create-bill')

    </div>
@endsection

@section('scripts')
    <script src="/js/bills.js"></script>
@endsection