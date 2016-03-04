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

                    <!-- BEGIN Page short description -->
                    <div class="number-of-application-products">
                        {{ trans('products_manager.short_page_description') }} @{{ products.total }} {{ trans('products_manager.products') }}.
                    </div>
                    <!-- END Page short description -->

                </div>
                <!-- END Page title and number of application products -->

                @include('admin-center.products-manager.partials._add-application-button')

            </div>
            <!-- END Top part -->

            <div class="primary-divider">
                {{ trans('products_manager.application_products') }}
                <span class="search-product" v-on="click: toggleSearch">{{ trans('products_manager.search_product') }}</span>
            </div>

            <!-- BEGIN Application product -->
            <div class="application-products" style="background-color: #F6F7F8">

                <div class="row">

                    <!-- BEGIN Search application products -->
                    <div class="form-group col-md-12 search-application-products">
                        <input v-model="search_term" v-on="keyup:search | key 13" id="search-application-products-input" type="text" class="form-control" placeholder="{{ trans('products_manager.search_placeholder') }}" />
                    </div>
                    <!-- END Search application products -->

                    <!-- BEGIN Search results text -->
                    <div v-show="searched" class="col-md-12 search-results-text">
                        <span>{{ trans('products_manager.search_results') }}:</span>
                    </div>
                    <!-- END Search results text -->

                    <!-- BEGIN No search results -->
                    <div class="col-md-12" v-show="searched && products.total < 1">
                        <div class="well custom-well no-search-results-text">
                            <strong>{{ trans('products_manager.no_search_results') }}</strong>
                            <a href="#" v-on="click:resetSearch">{{ trans('products_manager.click_here_to_show_all_products') }}</a>
                        </div>
                    </div>
                    <!-- END No search results -->

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
        @include('includes.modals.admin-center.products-manager.add-application-product.add-application-product')
    </div>
    <!-- END Products manager -->
@endsection

@section('scripts')
<script src="/js/admin-center_products-manager_index.js"></script>
@endsection