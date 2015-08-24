@extends('layout')
@section('content')
    <div id="bills">

        @include('templates.loader-template')
        <loader loaded="@{{ loaded }}"></loader>

        <div id="table" v-show="loaded">
            <h2>Hover Rows</h2>
            <p>The .table-hover class enables a hover state on table rows:</p>
            <table class="table table-hover" v-show="bills.total">
                <thead>
                <tr>
                    <th>Client</th>
                    <th>Campanie</th>
                    <th>Numarul de produse</th>
                    <th>Data</th>
                    <th>Sterge</th>
                </tr>
                </thead>
                <tbody>
                <tr v-repeat="bill in bills.data">
                    <td class="vert-align"><a href="#">@{{ bill.name }}</a></td>
                    <td class="vert-align">@{{ bill.campaign_number }} din @{{ bill.campaign_year }}</td>
                    <td class="vert-align">18</td>
                    <td class="vert-align">@{{ bill.payment_term }}</td>
                    <td class="vert-align"><button class="btn btn-danger" v-on="click: deleteBill(bill.id, bills.current_page, bills.to-bills.from,'{{ trans('common.loading') }}')">Sterge</button></td>
                </tr>
                </tbody>
            </table>

            <ul class="pager" v-show="bills.total > bills.per_page">
                <li v-class="disabled : !bills.prev_page_url"><a href="#" v-on="click: paginate(bills.prev_page_url)">Previous</a></li>
                <li v-class="disabled : !bills.next_page_url"><a href="#" v-on="click: paginate(bills.next_page_url)">Next</a></li>
            </ul>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="/js/bills.js"></script>
@endsection