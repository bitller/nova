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
                <span class="my-bills-title">{{ trans('bill.my_paid_bills') }} <span class="badge">@{{ paid_bills.total }}</span></span>
            </div>
            <!-- END Add bill button -->

            <!-- BEGIN Bills table-->
            <table class="table table-hover" v-show="paid_bills.total">
                <thead>
                <tr>
                    <th><span class="glyphicon glyphicon-user icon-color"></span>&nbsp; {{ trans('bills.client') }}</th>
                    <th><span class="glyphicon glyphicon-tag icon-color"></span>&nbsp; {{ trans('bills.campaign_order') }}</th>
                    <th><span class="glyphicon glyphicon-tags icon-color"></span>&nbsp; {{ trans('bills.campaign') }}</th>
                    <th><span class="glyphicon glyphicon-euro icon-color"></span>&nbsp; Pret</th>
                    <th><span class="glyphicon glyphicon-calendar icon-color"></span>&nbsp; {{ trans('bills.created_at') }}</th>
                    <th><span class="glyphicon glyphicon-trash icon-color"></span>&nbsp; {{ trans('common.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-repeat="bill in paid_bills.data">
                    <td class="vert-align"><a href="/bills/@{{bill.id}}">@{{ bill.client_name }}</a></td>
                    <td class="vert-align">@{{ bill.campaign_order }}</td>
                    <td class="vert-align">@{{ bill.campaign_number }} {{ trans('bills.from') }} @{{ bill.campaign_year }}</td>
                    <td class="vert-align">@{{ bill.price }} ron</td>
                    <td class="vert-align">@{{ bill.human_date }}</td>
                    <td class="vert-align"><button class="btn btn-danger" v-on="click: deleteBill(bill.id, paid_bills.current_page, paid_bills.to-paid_bills.from)"><span class="glyphicon glyphicon-trash"></span> {{ trans('common.delete') }}</button></td>
                </tr>
                </tbody>
            </table>
            <!-- END Bills table -->

            <!-- BEGIN Pagination links -->
            <ul class="pager" v-show="paid_bills.total > paid_bills.per_page">
                <li v-class="disabled : !paid_bills.prev_page_url"><a href="#" v-on="click: paginate(paid_bills.prev_page_url)">{{ trans('common.previous') }}</a></li>
                <li v-class="disabled : !paid_bills.next_page_url"><a href="#" v-on="click: paginate(paid_bills.next_page_url)">{{ trans('common.next') }}</a></li>
            </ul>
            <!-- END Pagination links -->

        </div>

    </div>
@endsection

@section('scripts')
    <script src="/js/paid-bills.js"></script>
@endsection