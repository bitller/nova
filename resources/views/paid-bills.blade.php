@extends('layout')
@section('content')
    <div id="paid-bills">

        @include('includes.ajax-translations.bills')

        <div id="table" v-show="loaded">
            <!-- BEGIN No bills info -->
            <div class="alert alert-info no-bills-info" v-show="!paid_bills.total">
                Aici apar toate facturile achitate. Momentan, se pare ca nu ai nicio factura achitata. Pentru a marca o factura ca achitata apasa butonul "Marcheaza ca platita" din pagina facturii. Cand o factura este achitata, ea va fi inclusa in statistici.
            </div>
            <!-- END No bills info -->

            <!-- BEGIN Add bill button -->
            <div class="add-bill-button" v-show="paid_bills.total">
                <span class="my-bills-title">{{ trans('bills.my_bills') }} <span class="badge">@{{ bills.total }}</span></span>
                <button type="button" class="btn btn-primary pull-right" v-on="click: createBill('{{ trans('bills.create') }}', '{{ trans('bills.client_name') }}', '{{ trans('bills.client_name_required') }}', '{{ trans('bills.bill_created') }}', '{{ trans('common.loading') }}', '{{ trans('common.success') }}')">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('bills.create') }}
                </button>
            </div>
            <!-- END Add bill button -->

            <!-- BEGIN Bills table-->
            <table class="table table-hover" v-show="paid_bills.total">
                <thead>
                <tr>
                    <th><span class="glyphicon glyphicon-user icon-color"></span> {{ trans('bills.client') }}</th>
                    <th><span class="glyphicon glyphicon-tag icon-color"></span> {{ trans('bills.campaign_order') }}</th>
                    <th><span class="glyphicon glyphicon-tags icon-color"></span> {{ trans('bills.campaign') }}</th>
                    <th><span class="glyphicon glyphicon-euro icon-color"></span> Pret</th>
                    <th><span class="glyphicon glyphicon-calendar icon-color"></span> {{ trans('bills.created_at') }}</th>
                    <th><span class="glyphicon glyphicon-trash icon-color"></span> {{ trans('common.delete') }}</th>
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

    </div>
@endsection

@section('scripts')
    <script src="/js/paid-bills.js"></script>
@endsection