@extends('layout')

@section('styles')
    <link rel="stylesheet" media="print" href="/css/print.css">
@endsection

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
                    &nbsp;&nbsp;<span v-show="paid > 0" class="paid-bill glyphicon glyphicon-ok" data-toggle="tooltip" title="{{ trans('bill.tooltip') }}" data-placement="right"></span>
                </span>
                <!-- END Client name and campaign details -->

                <div class="text-center bill-title-print">
                    <span>
                        @{{ bill.data.client_name }} - {{ trans('bill.order') }} @{{ bill.data.campaign_order }} {{ trans('bill.from_campaign') }} @{{ bill.data.campaign_number }}/@{{ bill.data.campaign_year }}
                    </span>
                </div>

                <!-- BEGIN Action buttons -->
                <div class="action-buttons btn-toolbar pull-right">

                    <!-- BEGIN Print button -->
                    <button type="button" class="btn btn-default" v-on="click: printBill">
                        <span class="glyphicon glyphicon-print"></span>
                    </button>
                    <!-- END Print button -->

                    <!-- BEGIN Options button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-cog"></span> {{ trans('bill.options') }}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">

                            <!-- BEGIN Edit other details -->
                            <li>
                                <a href="#" v-on="click: resetOtherDetailsModal()" data-toggle="modal" data-target="#other-details-modal">
                                    <span class="glyphicon glyphicon-pencil"></span> {{ trans('bill.edit_other_details') }}
                                </a>
                            </li>
                            <!-- END Edit other details -->

                            <!-- BEGIN Set payment term -->
                            <li>
                                <a href="#" v-on="click: resetPaymentTermModal()" data-toggle="modal" data-target="#payment-term-modal">
                                    <span class="glyphicon glyphicon-calendar"></span> {{ trans('bill.set_payment_term') }}
                                </a>
                            </li>
                            <!-- END Set payment term -->

                            <!-- BEGIN Mark as paid -->
                            <li v-show="paid < 1">
                                <a href="#" v-on="click: markAsPaid()">
                                    <span class="glyphicon glyphicon-ok"></span> {{ trans('bill.mark_as_paid') }}
                                </a>
                            </li>
                            <!-- END Mark as paid -->

                            <!-- BEGIN Mark as unpaid -->
                            <li v-show="paid > 0">
                                <a href="#" v-on="click: markAsUnpaid()">
                                    <span class="glyphicon glyphicon-remove"></span> {{ trans('bill.mark_as_unpaid') }}
                                </a>
                            </li>
                            <!-- END Mark as unpaid -->

                            <li class="divider"></li>

                            <!-- BEGIN Delete bill -->
                            <li>
                                <a href="#" v-on="click: deleteBill()">
                                    <span class="glyphicon glyphicon-trash"></span> {{ trans('bill.delete') }}
                                </a>
                            </li>
                            <!-- END Delete bill -->
                        </ul>
                    </div>
                    <!-- END Options button -->

                    <!-- BEGIN Add product button -->
                    <button type="button" class="btn btn-primary pull-right" v-on="click: resetAddProductToBillModal()" data-toggle="modal" data-target="#addProductToBillModal">
                        <span class="glyphicon glyphicon-plus"></span> {{ trans('products.add') }}
                    </button>
                    <!-- END Add product button -->
                </div>
                <!-- END Action buttons -->

            </div>
            <!-- BEGIN Bill top part -->

            <!-- BEGIN Bill table -->
            <div class="panel panel-default" v-show="bill.total">
                <table class="table table-bordered bill-products-table">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('bill.page') }}</th>
                            <th class="text-center">{{ trans('bill.code') }}</th>
                            <th class="text-center">{{ trans('bill.name') }}</th>
                            <th class="text-center">{{ trans('bill.quantity') }}</th>
                            <th class="text-center">{{ trans('bill.price') }}</th>
                            <th class="text-center" v-show="bill.show_discount_column">{{ trans('bill.discount') }}</th>
                            <th class="text-center" v-show="bill.show_discount_column">{{ trans('bill.final_price') }}</th>
                            <th class="text-center delete-product">{{ trans('common.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="product in bill.products">
                        <td class="text-center editable"  v-on="click: editPage(product.page, product.id, product.code, product.bill_product_id)">@{{ product.page }}</td>
                        <td class="text-center">@{{ product.code }}</td>
                        <td class="text-center">@{{ product.name }}</td>
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

            <!-- BEGIN Bill other details -->
            <div class="panel panel-default" v-show="other_details && bill.total">
                <div class="panel-heading">{{ trans('bill.other_details') }}</div>
                <div class="panel-body">
                    @{{{ other_details }}}
                </div>
            </div>
            <!-- END Bill other details -->

            <!-- BEGIN Bill payment term -->
            <div class="well well-sm custom-well col-md-3 text-center" v-show="bill.total">
                <span v-show="payment_term" class="text-center">{{ trans('bill.payment_term') }}: <strong>@{{ payment_term }}</strong></span>
                <span v-show="!payment_term" class="text-center">{{ trans('bill.payment_term_not_set') }}</span>
            </div>
            <!-- END Bill payment term -->

            <div class="col-md-2"></div>

            <!-- BEGIN Bill total price -->
            <div class="well well-sm custom-well col-md-2 text-center" v-show="bill.total">
                <span class="text-center">{{ trans('bill.to_pay') }}: <strong>@{{ to_pay }} ron</strong></span>
            </div>
            <!-- END Bill total price -->

            <div class="col-md-2"></div>

            <!-- BEGIN Bill total discount -->
            <div class="well well-sm custom-well col-md-3 text-center" v-show="bill.total">
                <span v-show="saved_money">{{ trans('bill.saved_money') }}: <strong>@{{ saved_money }} ron</strong></span>
                <span v-show="!saved_money">{{ trans('bill.number_of_products') }}: <strong>@{{ number_of_products }}</strong></span>
            </div>
            <!-- END Bill total discount -->

            <div class="alert alert-info" v-show="!bill.total">{{ trans('bill.empty_bill') }}</div>

        </div>

        @include('includes.modals.add-product-to-bill')
        @include('includes.modals.other-details')
        @include('includes.modals.payment-term')

    </div>
    <!-- END Bill -->
@endsection
@section('scripts')
    <script src="/js/bill.js"></script>
@endsection