@extends('layout')
@section('content')
    @include('includes.ajax-translations.common')
    @include('includes.ajax-translations.my-products')
    <div id="my-products">
        <div v-show="loaded">

            <!-- BEGIN Add product button -->
            <div class="add-product-button">
                <span class="avon-products">{{ trans('my_products.my_products') }} <span class="badge">@{{ myProducts.total }}</span></span>
                <button type="button" class="btn btn-primary pull-right" v-on="click: addProduct(myProducts.current_page, myProducts.to-myProducts.from)">
                        <span class="glyphicon glyphicon-plus"></span> {{ trans('my_products.add_product') }}
                </button>
            </div>
            <!-- END Add product button -->

            <!-- BEGIN Products table-->
            <div class="panel panel-default">
                <table class="table table-bordered" v-show="myProducts.total">
                    <thead>
                    <tr>
                        <th>{{ trans('common.product_code') }}</th>
                        <th>{{ trans('common.product_name') }}</th>
                        <th>{{ trans('my_products.delete_product') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="product in myProducts.data">
                        <td class="vert-align">@{{ product.code }}</td>
                        <td class="vert-align">@{{ product.name }}</td>
                        <td class="vert-align"><button class="btn btn-danger" v-on="click: deleteMyProduct(product.id, myProducts.current_page, myProducts.to-myProducts.from)">{{ trans('common.delete') }}</button></td>
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
    </div>
@endsection

@section('scripts')
    <script src="/js/my-products.js"></script>
@endsection