@extends('layout')
@section('content')
    @include('includes.ajax-translations.common')
    @include('includes.ajax-translations.products')
    <div id="products">
        <div v-show="loaded">

            <!-- BEGIN Add product button -->
            <div class="add-product-button">
                <span class="avon-products">{{ trans('products.avon_products') }} <span class="badge" data-toggle="tooltip" title="{{ trans('products.tooltip') }}" data-placement="right">@{{ products.total }}</span></span>
                <a href="/my-products"><button type="button" class="btn btn-primary pull-right" v-on="click: addClient()">
                    <span class="glyphicon glyphicon-link"></span> {{ trans('products.my_products') }}
                </button></a>
            </div>
            <!-- END Add product button -->

            <!-- BEGIN Products table-->
            <div class="panel panel-default">
                <table class="table table-bordered" v-show="products.total">
                    <thead>
                    <tr>
                        <th class="text-center">{{ trans('common.product_code') }}</th>
                        <th class="text-center">{{ trans('common.product_name') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="product in products.data">
                        <td class="vert-align text-center"><a href="/product-details/@{{ product.code }}">@{{ product.code }}</a></td>
                        <td class="vert-align text-center"><a href="/product-details/@{{ product.code }}">@{{ product.name }}</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- END Products table -->

            <!-- BEGIN Pagination links -->
            <ul class="pager" v-show="products.total > products.per_page">
                <li v-class="disabled : !products.prev_page_url"><a href="#" v-on="click: paginate(products.prev_page_url)">{{ trans('common.previous') }}</a></li>
                <li v-class="disabled : !products.next_page_url"><a href="#" v-on="click: paginate(products.next_page_url)">{{ trans('common.next') }}</a></li>
            </ul>
            <!-- END Pagination links -->

        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/products.js"></script>
    <script src="/js/header-search.js"></script>
@endsection