@extends('layout.index')
@section('content')

    @include('includes.ajax-translations.common')

    <!-- BEGIN Products manager -->
    <div id="products-manager-index" class="well custom-well-with-no-padding" v-show="loaded">

        <div>
            <!-- BEGIN Top part -->
            <div class="top-part">

                <!-- BEGIN Page title and number of application products -->
                <div class="title-and-number-of-products">

                    <!-- BEGIN Page title -->
                    <div class="title">
                        {{ trans('products_manager.products_manager') }}
                    </div>
                    <!-- END Page title -->

                    <!-- BEGIN Number of application products -->
                    <div class="number-of-application-products">
                        {{ trans('products_manager.there_are') }} @{{ products.total }} {{ trans('products_manager.products') }}.
                    </div>
                    <!-- END Number of application products -->

                </div>
                <!-- END Page title and number of application products -->

                @include('admin-center.products-manager.partials._add-application-button')

            </div>
            <!-- END Top part -->

            <div class="primary-divider">
                {{ trans('products_manager.application_products') }}
                <span class="search-product">{{ trans('products_manager.search_product') }}</span>
            </div>

            <!-- BEGIN Application product -->
            <div class="application-products" style="background-color: #F6F7F8">

                <div class="row">
                    <div class="col-md-6" v-repeat="product in products.data">
                        <div class="well custom-well">

                            <strong class="product-title">
                                <a href="/admin-center/products-manager/product/@{{ product.id }}/@{{ product.code }}">@{{ product.code }} - @{{ product.name }}</a>
                            </strong>

                            <div class="product-details">
                                <strong>{{ trans('products_manager.added_on') }}:</strong> @{{ product.created_at }}
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin-center.products-manager.partials._pagination')

            </div>
            <!-- END Application product -->

        </div>
    </div>
    <!-- END Products manager -->
@endsection

@section('scripts')
<script src="/js/admin-center_products-manager_index.js"></script>
@endsection