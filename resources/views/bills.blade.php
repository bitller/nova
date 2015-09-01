@extends('layout')
@section('content')
    <div id="bills">

        @include('templates.loader-template')
        <loader loaded="@{{ loaded }}"></loader>

        <div id="table" v-show="loaded">
            <!-- BEGIN No bills info -->
            <div class="alert alert-info no-bills-info" v-show="!bills.total">
                 Se pare ca nu ai nici o factura creata. Dupa ce ai creeat o facutra poti incepe sa adaugi produse iar apoi sa o imprimezi. Daca ai nelamuriri sau vrei sa aflii mai multe detalii, acceseaza sectiunea <strong><a href="#">Facturi.</a></strong> In cazul in care tot mai ai nelamuriri, nu ezita sa ne <strong><a href="#">contactezi.</a></strong>
            </div>
            <!-- END No bills info -->

            <!-- BEGIN Add bill button -->
            <div class="add-bill-button">
                <span class="my-bills-title">{{ trans('bills.my_bills') }} (@{{ bills.total }})</span>
                <button type="button" class="btn btn-danger pull-right" v-on="click: createBill('{{ trans('bills.create') }}', '{{ trans('bills.client_name') }}', '{{ trans('bills.client_name_required') }}', '{{ trans('bills.bill_created') }}', '{{ trans('common.loading') }}', '{{ trans('common.success') }}')">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('bills.create') }}
                </button>
            </div>
            <!-- END Add bill button -->

            <!-- BEGIN Bills table-->
            <table class="table table-hover" v-show="bills.total">
                <thead>
                <tr>
                    <th>{{ trans('bills.client') }}</th>
                    <th>{{ trans('bills.campaign') }}</th>
                    <th>{{ trans('bills.number_of_products') }}</th>
                    <th>{{ trans('bills.created_at') }}</th>
                    <th>{{ trans('common.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-repeat="bill in bills.data">
                    <td class="vert-align"><a href="/bills/@{{bill.id}}">@{{ bill.client_name }}</a></td>
                    <td class="vert-align">@{{ bill.campaign_number }} din @{{ bill.campaign_year }}</td>
                    <td class="vert-align">18</td>
                    <td class="vert-align">@{{ bill.created_at }}</td>
                    <td class="vert-align"><button class="btn btn-warning" v-on="click: deleteBill(bill.id, bills.current_page, bills.to-bills.from,'{{ trans('common.loading') }}')"><span class="glyphicon glyphicon-trash"></span> {{ trans('common.delete') }}</button></td>
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
    <script src="/js/bills.js"></script>
@endsection