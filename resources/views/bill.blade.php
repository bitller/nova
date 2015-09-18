@extends('layout')
@section('content')
    @include('includes.ajax-translations.bill')
    <div id="bill" bill-id="{{ $billId }}" v-show="loaded">
        <div class="col-md-12 bill-menu">
            <div class="col-md-3">
                <button class="btn btn-block btn-default">
                    <span class="glyphicon glyphicon-print"></span> Print bill
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-block btn-default">
                    <span class="glyphicon glyphicon-pencil"></span> Edit other details
                </button>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-block btn-default">
                    <span class="glyphicon glyphicon-plus"></span> Add product
                </button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-block btn-default">
                    <span class="glyphicon glyphicon-calendar"></span> Edit payment term
                </button>
            </div>
        </div>
        <div class="col-md-12">
        <h4 class="bill-title"><a href="#">John Doe</a> (acest client mai are 2 facturi)</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">{{ trans('bill.page') }}</th>
                    <th class="text-center">{{ trans('bill.code') }}</th>
                    <th>{{ trans('bill.name') }}</th>
                    <th class="text-center">{{ trans('bill.quantity') }}</th>
                    <th class="text-center">{{ trans('bill.price') }}</th>
                    <th class="text-center">{{ trans('bill.discount') }}</th>
                    <th class="text-center">{{ trans('bill.final_price') }}</th>
                    <th class="text-center">Sterge</th>
                </tr>
            </thead>
            <tbody>

            <tr v-repeat="product in bill">
                <td class="text-center editable">@{{ product.page }}</td>
                <td class="text-center">@{{ product.code }}</td>
                <td>@{{ product.name }}</td>
                <td class="text-center editable">@{{ product.quantity }}</td>
                <td class="text-center editable">@{{ product.price }} ron</td>
                <td class="text-center editable">@{{ product.discount }}</td>
                <td class="text-center">9.00 ron</td>
                <td class="text-center editable delete-product"  v-on="click: deleteProduct(product.id)"><span class="glyphicon glyphicon-trash"></span></td>
            </tr>

            </tbody>
        </table></div>
    </div>
@endsection
@section('scripts')
    <script src="/js/bill.js"></script>
@endsection