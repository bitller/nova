@extends('layout')
@section('content')
    @include('includes.ajax-translations.products')
    <div id="products">
        <div v-show="loaded">

            <!-- BEGIN Add product button -->
            <div class="add-product-button">
                <span class="avon-products">{{ trans('products.avon_products') }} (@{{ products.total }})</span>
                <button class="btn btn-default" data-toggle="popover" data-trigger="focus" data-content="{{ trans('products.page_help') }}">{{ trans('common.page_details') }}</button>
                <a href="/my-products"><button type="button" class="btn btn-primary pull-right" v-on="click: addClient()">
                    <span class="glyphicon glyphicon-link"></span> {{ trans('products.my_products') }}
                </button></a>
            </div>
            <!-- END Add product button -->

            <!-- BEGIN Products table-->
            <table class="table table-bordered" v-show="products.total">
                <thead>
                <tr>
                    <th>{{ trans('products.code') }}</th>
                    <th>{{ trans('products.name') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-repeat="product in products.data">
                    <td class="vert-align">@{{ product.code }}</td>
                    <td class="vert-align">@{{ product.name }}</td>
                </tr>
                </tbody>
            </table>
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
@endsection