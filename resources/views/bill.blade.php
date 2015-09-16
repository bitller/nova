@extends('layout')
@section('content')
    @include('includes.ajax-translations.bill')
    <div id="bill" bill-id="{{ $billId }}" v-show="loaded">
        <h4><a href="#">John Doe</a></h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">{{ trans('bill.page') }}</th>
                    <th class="text-center">{{ trans('bill.code') }}</th>
                    <th>{{ trans('bill.name') }}</th>
                    <th class="text-center">{{ trans('bill.quantity') }}</th>
                    <th class="text-center">{{ trans('bill.price') }}</th>
                    <th class="text-center">{{ trans('bill.discount') }}</th>
                    <th class="text-center">{{ trans('bill.final_price') }}</th>
                </tr>
            </thead>
            <tbody>
            <tr v-repeat="product in bill">
                <td class="text-center">1</td>
                <td class="text-center">10</td>
                <td class="text-center">@{{ product.code }}</td>
                <td>@{{ product.name }}</td>
                <td class="text-center">x4</td>
                <td class="text-center">10.00 ron</td>
                <td class="text-center">10% - 1.00 ron</td>
                <td class="text-center">9.00 ron</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script src="/js/bill.js"></script>
@endsection