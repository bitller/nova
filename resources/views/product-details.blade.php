@extends('layout')
@section('content')

    @include('includes.ajax-translations.common')

    <div id="product-details" product-code="{{ $productCode }}">
        <div v-show="loaded">

            <!-- BEGIN Top part -->
            <div class="add-product-button row">
                <span class="avon-products">Numele produsului</span>

                <div class="btn-toolbar pull-right">

                    <!-- BEGIN Edit button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp; {{ trans('common.edit') }}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">

                            <!-- BEGIN Edit name -->
                            <li>
                                <a href="#">
                                    <span class="glyphicon glyphicon-font"></span>&nbsp; {{ trans('product_details.edit_name') }}
                                </a>
                            </li>
                            <!-- END Edit name -->

                            <!-- BEGIN Edit code -->
                            <li>
                                <a href="#">
                                    <span class="glyphicon glyphicon-asterisk"></span>&nbsp; {{ trans('product_details.edit_code') }}
                                </a>
                            </li>
                            <!-- END Edit code -->

                            <li class="divider"></li>

                            <li>
                                <a href="#">
                                    <span class="glyphicon glyphicon-trash"></span>&nbsp; {{ trans('product_details.delete_product') }}
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- END Edit button -->
                </div>
            </div>
            <!-- END Top part -->

            <!-- BEGIN Product statistics -->
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item active"><span class="glyphicon glyphicon-stats"></span>&nbsp; {{ trans('product_details.product_statistics') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ product.sold_pieces }}</span> {{ trans('product_details.number_of_sold_pieces') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ product.total_price }}</span> {{ trans('product_details.total_price') }}</li>
                </ul>
            </div>
            <!-- END Product statistics -->

            <!-- BEGIN Not paid bills that contain this product -->
            <div class="row client-bills">
                <h4>{{ trans('product_details.bills_that_contain_product') }}</h4>
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ trans('product_details.client_name') }}</th>
                            <th>{{ trans('bills.number_of_products') }}</th>
                            <th>{{ trans('bills.campaign') }}</th>
                            <th>{{ trans('bills.created_at') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-repeat="not_paid_bill in product.not_paid_bills">
                            <td><a href="#">@{{ not_paid_bill.client_name }}</a></td>
                            <td>0</td>
                            <td>@{{ not_paid_bill.campaign_number }}</td>
                            <td>@{{ not_paid_bill.created_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Not paid bills that contain this product -->

            <!-- BEGIN Paid bills that contain this product -->
            <div class="row client-bills">
                <h4>{{ trans('product_details.paid_bills_that_contain_product') }}</h4>
                <div class="panel panel-default">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ trans('product_details.client_name') }}</th>
                            <th>{{ trans('bills.number_of_products') }}</th>
                            <th>{{ trans('bills.campaign') }}</th>
                            <th>{{ trans('bills.created_at') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-repeat="paid_bill in product.paid_bills">
                            <td><a href="#">@{{ paid_bill.client_name }}</a></td>
                            <td>0</td>
                            <td>@{{ paid_bill.campaign_number }}</td>
                            <td>@{{ paid_bill.created_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END paid bills that contain this product -->

        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/product-details.js"></script>
@endsection