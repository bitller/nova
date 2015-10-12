@extends('layout')
@section('content')
    @include('includes.ajax-translations.bill')

    <!-- BEGIN Bill -->
    <div id="bill" bill-id="{{ $billId }}" v-show="loaded">

        <div class="col-md-12">

            <!-- BEGIN Bill top part -->
            <div class="add-client-button btn-toolbar">
                <!-- BEGIN Client name and campaign details -->
                <span class="my-clients-title">
                    <a href="/clients/@{{ bill.data.client_id }}">@{{ bill.data.client_name }}</a> - comanda @{{ bill.data.campaign_order }} din campania @{{ bill.data.campaign_number }}/@{{ bill.data.campaign_year }}
                </span>
                <!-- END Client name and campaign details -->

                <!-- BEGIN Action buttons -->
                <div class="btn-toolbar pull-right">
                    <!-- BEGIN Options button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-cog"></span> Optiuni
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#"> <span class="glyphicon glyphicon-print"></span> {{ trans('bill.print') }}</a></li>
                            <li><a href="#" v-on="click: resetOtherDetailsModal()" data-toggle="modal" data-target="#other-details-modal"> <span class="glyphicon glyphicon-pencil"></span> {{ trans('bill.edit_other_details') }}</a></li>
                            <li><a href="#"> <span class="glyphicon glyphicon-calendar"></span> {{ trans('bill.set_payment_term') }}</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><span class="glyphicon glyphicon-trash"></span> {{ trans('bill.delete') }}</a></li>
                        </ul>
                    </div>
                    <!-- END Options button -->

                    <!-- BEGIN Add product button -->
                    <button type="button" class="btn btn-primary pull-right" v-on="click: resetModal()" data-toggle="modal" data-target="#addProductToBillModal">
                        <span class="glyphicon glyphicon-plus"></span> {{ trans('products.add') }}
                    </button>
                    <!-- END Add product button -->
                </div>
                <!-- END Action buttons -->

            </div>
            <!-- BEGIN Bill top part -->

            <!-- BEGIN Bill table -->
            <div class="panel panel-default">
                <table class="table table-bordered bill-products-table">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('bill.page') }}</th>
                            <th class="text-center">{{ trans('bill.code') }}</th>
                            <th>{{ trans('bill.name') }}</th>
                            <th class="text-center">{{ trans('bill.quantity') }}</th>
                            <th class="text-center">{{ trans('bill.price') }}</th>
                            <th class="text-center" v-show="bill.show_discount_column">{{ trans('bill.discount') }}</th>
                            <th class="text-center" v-show="bill.show_discount_column">{{ trans('bill.final_price') }}</th>
                            <th class="text-center">Sterge</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="product in bill.products">
                        <td class="text-center editable"  v-on="click: editPage(product.page, product.id, product.code, product.bill_product_id)">@{{ product.page }}</td>
                        <td class="text-center">@{{ product.code }}</td>
                        <td>@{{ product.name }}</td>
                        <td class="text-center editable" v-on="click: editQuantity(product.quantity, product.id, product.code, product.bill_product_id)">@{{ product.quantity }}</td>
                        <td class="text-center editable" v-on="click: editPrice(product.price, product.id, product.code, product.bill_product_id)">@{{ product.price }} ron</td>
                        <td class="text-center editable" v-show="bill.show_discount_column" v-on="click: editDiscount(product.discount, product.id, product.code, product.bill_product_id)">@{{ product.discount }}% - @{{ product.calculated_discount }} ron</td>
                        <td class="text-center" v-show="bill.show_discount_column">@{{ product.final_price }} ron</td>
                        <td class="text-center editable delete-product"  v-on="click: deleteProduct(product.id, product.code, product.bill_product_id)"><span class="glyphicon glyphicon-trash"></span></td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- END Bill table -->

            <div class="panel panel-default" v-show="other_details">
                <div class="panel-heading">Alte detalii</div>
                <div class="panel-body">
                    @{{{ other_details }}}
                </div>
            </div>

            <div class="well well-sm col-md-3 text-center">
                <span class="text-center">Termen de plata: <strong>04.01.2016</strong></span>
            </div>
            <div class="col-md-2"></div>

            <div class="well well-sm col-md-2 text-center">
                <span class="text-center">Total: <strong>100 ron</strong></span>
            </div>
            <div class="col-md-2"></div>
            <div class="well well-sm col-md-3 text-center">
                <span>Economisiti: <strong>1000 ron</strong></span>
            </div>

        </div>

        @include('includes.modals.add-product-to-bill')
        @include('includes.modals.other-details')

    </div>
    <!-- END Bill -->
@endsection
@section('scripts')
    <script src="/js/bill.js"></script>
@endsection