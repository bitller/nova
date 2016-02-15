@extends('layout')
@section('content')
    @include('includes.ajax-translations.common')
    @include('includes.ajax-translations.my-products')
    <div id="my-products">
        <div v-show="loaded">

            <!-- BEGIN Add product button -->
            <div class="add-product-button">
                <span class="avon-products">{{ trans('my_products.my_products') }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('my_products.number_of_products_added') }}">@{{ myProducts.total }}</span></span>
                <button type="button" class="btn btn-primary pull-right" data-target="#add-custom-product-modal" data-toggle="modal">
                        <span class="glyphicon glyphicon-plus"></span> {{ trans('my_products.add_product') }}
                </button>
            </div>
            <!-- END Add product button -->

            <!-- BEGIN No product info -->
            <div class="alert alert-info" v-show="!myProducts.total">
                {{ trans('my_products.no_products') }}
            </div>
            <!-- END No products info -->

            <!-- BEGIN Products table-->
            <div class="panel panel-default" v-show="myProducts.total">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">{{ trans('common.product_code') }}</th>
                        <th class="text-center">{{ trans('common.product_name') }}</th>
                        <th class="text-center">{{ trans('my_products.delete_product') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="product in myProducts.data">
                        <td class="text-center vert-align"><a href="/product-details/@{{ product.code }}">@{{ product.code }}</a></td>
                        <td class="text-center vert-align"><a href="/product-details/@{{ product.code }}">@{{ product.name }}</a></td>
                        <td class="text-center vert-align"><button class="btn btn-default" v-on="click: deleteMyProduct(product.id, myProducts.current_page, myProducts.to-myProducts.from)"><span class="glyphicon glyphicon-trash"></span>&nbsp;{{ trans('common.delete') }}</button></td>
                    </tr>
                    </tbody>
                </table>
                <!-- END Products table -->
            </div>

            <!-- BEGIN Pagination links -->
            <ul class="pager" v-show="myProducts.total > myProducts.per_page">
                <li v-class="disabled : !myProducts.prev_page_url"><a href="#" v-on="click: paginate(myProducts.prev_page_url)">{{ trans('common.previous') }}</a></li>
                <li v-class="disabled : !myProducts.next_page_url"><a href="#" v-on="click: paginate(myProducts.next_page_url)">{{ trans('common.next') }}</a></li>
            </ul>
            <!-- END Pagination links -->

        </div>

        @include('includes.modals.add-custom-product')

    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/my-products.js"></script>
@endsection