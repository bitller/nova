@extends('layout.index')
@section('content')

    @include('includes.ajax-translations.product-details')

    <div id="product-details" product-code="{{ $productCode }}" v-show="loaded">
        <div id="products" class="well custom-well-with-no-padding">
            <div>
                <!-- BEGIN Top part -->
                <div class="ff-top-part">

                    <!-- BEGIN Page title and description -->
                    <div class="ff-title-and-description">

                        <!-- BEGIN Page title -->
                        <div class="ff-title">
                            @{{ product.name }} - @{{ product.code }}
                        </div>
                        <!-- END Page title -->

                        <!-- BEGIN Page short description -->
                        <div class="ff-description">
                            {{ trans('product_details.added_on') }} @{{ product.created_at.date }}
                        </div>
                        <!-- END Page short description -->

                    </div>
                    <!-- END Page title and description -->

                    {{--<div class="btn-toolbar pull-right" v-show="!product.is_application_product">--}}

                    <!-- BEGIN Edit button -->
                    <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-pencil"></span>&nbsp; {{ trans('common.edit') }}
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">

                    <!-- BEGIN Edit name -->
                    <li>
                    <a href="#" v-on="click: editName(name, product.code, product.id)">
                    <span class="glyphicon glyphicon-font"></span>&nbsp; {{ trans('product_details.edit_name') }}
                    </a>
                    </li>
                    <!-- END Edit name -->

                    <!-- BEGIN Edit code -->
                    <li>
                    <a href="#" v-on="click: editCode(product.code, product.id)">
                    <span class="glyphicon glyphicon-asterisk"></span>&nbsp; {{ trans('product_details.edit_code') }}
                    </a>
                    </li>
                    <!-- END Edit code -->

                    <li class="divider"></li>

                    <li>
                    <a href="#" v-on="click: deleteProduct(product.code, product.id)">
                    <span class="glyphicon glyphicon-trash"></span>&nbsp; {{ trans('product_details.delete_product') }}
                    </a>
                    </li>

                    </ul>
                    </div>
                    <!-- END Edit button -->
                    </div>

                </div>
                <!-- END Top part -->

                <!-- BEGIN Paid bills that contain this product divider -->
                <div class="ff-primary-divider">
                    <span>{{ trans('product_details.paid_bills_that_contain_product') }}</span>
                </div>
                <!-- END Paid bills that contain this product divider -->

                <!-- BEGIN Paid bills that contain this product -->
                <div class="ff-content">
                    <div class="panel panel-default" v-show="product.paid_bills[0]">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ trans('product_details.client_name') }}</th>
                                    <th class="text-center">{{ trans('bills.campaign_order') }}</th>
                                    <th class="text-center">{{ trans('bills.campaign') }}</th>
                                    <th class="text-center">{{ trans('bills.created_at') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-repeat="paid_bill in product.paid_bills">
                                    <td class="text-center"><a href="/bills/@{{ paid_bill.id }}">@{{ paid_bill.client_name }}</a></td>
                                    <td class="text-center">@{{ paid_bill.campaign_order }}</td>
                                    <td class="text-center">@{{ paid_bill.campaign_number }}/@{{ paid_bill.campaign_year }}</td>
                                    <td class="text-center">@{{ paid_bill.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-info" v-show="!product.paid_bills[0]">
                        {{ trans('product_details.product_not_appear_in_any_paid_bill') }}
                    </div>
                </div>
                <!-- END Paid bills that contain this product -->

                <!-- BEGIN Unpaid bills that contains this product divider -->
                <div class="ff-primary-divider">
                    <span>{{ trans('product_details.unpaid_bills_that_contain_this_product') }}</span>
                </div>
                <!-- END Unpaid bills that contains this product divider -->

                <!-- BEGIN Unpaid bills that contains this product -->
                <div class="ff-content">
                    <div class="panel panel-default" v-show="product.not_paid_bills[0]">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ trans('product_details.client_name') }}</th>
                                    <th class="text-center">{{ trans('bills.campaign_order') }}</th>
                                    <th class="text-center">{{ trans('bills.campaign') }}</th>
                                    <th class="text-center">{{ trans('bills.created_at') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-repeat="not_paid_bill in product.not_paid_bills">
                                    <td class="text-center"><a href="/bills/@{{ not_paid_bill.id }}">@{{ not_paid_bill.client_name }}</a></td>
                                    <td class="text-center">@{{ not_paid_bill.campaign_order }}</td>
                                    <td class="text-center">@{{ not_paid_bill.campaign_number }}/@{{ not_paid_bill.campaign_year }}</td>
                                    <td class="text-center">@{{ not_paid_bill.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info" v-show="!product.not_paid_bills[0]">
                        {{ trans('product_details.product_not_appear_in_any_unpaid_bill') }}
                    </div>

                </div>
                <!-- END Unpaid bills that contains this product divider -->

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/product-details.js"></script>
@endsection