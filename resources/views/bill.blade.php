@extends('layout')
@section('content')
    @include('includes.ajax-translations.bill')
    <div id="bill" bill-id="{{ $billId }}" v-show="loaded">
        <div class="col-md-12">
            <div class="add-client-button">
                <span class="my-clients-title"><a href="#">John Doe</a> - comanda 1 din campania 3/2015</span>
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addProductToBillModal">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('products.add') }}
                </button>
            </div>
        <table class="table table-bordered bill-products-table">
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
                <td class="text-center editable"  v-on="click: editPage(product.page, product.id, product.code, product.bill_product_id)">@{{ product.page }}</td>
                <td class="text-center">@{{ product.code }}</td>
                <td>@{{ product.name }}</td>
                <td class="text-center editable" v-on="click: editQuantity(product.quantity, product.id, product.code, product.bill_product_id)">@{{ product.quantity }}</td>
                <td class="text-center editable" v-on="click: editPrice(product.price, product.id, product.code, product.bill_product_id)">@{{ product.price }} ron</td>
                <td class="text-center editable" v-on="click: editDiscount(product.discount, product.id, product.code, product.bill_product_id)">@{{ product.discount }}% - @{{ product.calculated_discount }} ron</td>
                <td class="text-center">@{{ product.final_price }} ron</td>
                <td class="text-center editable delete-product"  v-on="click: deleteProduct(product.id, product.code, product.bill_product_id)"><span class="glyphicon glyphicon-trash"></span></td>
            </tr>

            </tbody>
        </table></div>

        @include('includes.modals.add-product-to-bill')

    </div>

@endsection
@section('scripts')
    <script src="/js/bill.js"></script>
@endsection