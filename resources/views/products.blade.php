@extends('layout.index')
@section('content')
    @include('includes.ajax-translations.common')
    @include('includes.ajax-translations.products')

    <div id="products" class="well custom-well-with-no-padding" v-show="loaded">
        <div>
            <!-- BEGIN Top part -->
            <div class="ff-top-part">

                <!-- BEGIN Page title and description -->
                <div class="ff-title-and-description">

                    <!-- BEGIN Page title -->
                    <div class="ff-title">
                        {{ trans('products.page_title') }}
                    </div>
                    <!-- END Page title -->

                    <!-- BEGIN Page short description -->
                    <div class="ff-description">
                        {{ trans('products.page_description') }}
                    </div>
                    <!-- END Page short description -->

                </div>
                <!-- END Page title and description -->

                <!-- BEGIN My products button -->
                <a href="/my-products">
                    <button class="btn btn-primary pull-right">
                        <i class="glyphicon glyphicon-link"></i>
                        {{ trans('products.my_products') }}
                    </button>
                </a>
                <!-- END My products button -->

            </div>
            <!-- END Top part -->

            <!-- BEGIN Primary divider -->
            <div class="ff-primary-divider">
                <span class="search-product pointer" v-on="click: toggleSearch">{{ trans('products.search_product') }}</span>
            </div>
            <!-- END Primary divider -->

            <!-- BEGIN Content -->
            <div class="ff-content">
                <div class="row">

                    <!-- BEGIN Search application products -->
                    <div class="form-group col-md-12 search-application-products">
                        <input v-model="search_term" v-on="keyup:search | key 13" id="search-application-products-input" type="text" class="form-control" placeholder="{{ trans('products_manager.search_placeholder') }}" />
                    </div>
                    <!-- END Search application products -->

                    <!-- BEGIN Search results text -->
                    <div v-show="searched" class="col-md-12 search-results-text">
                        <strong>{{ trans('products_manager.search_results') }}:</strong>
                    </div>
                    <!-- END Search results text -->

                    <!-- BEGIN No search results -->
                    <div class="col-md-12" v-show="searched && products.total < 1">
                        <div class="well custom-well no-search-results-text">
                            <strong>
                                {{ trans('products_manager.no_search_results') }}
                                <a href="#" v-on="click:resetSearch">{{ trans('products_manager.click_here_to_show_all_products') }}</a>
                            </strong>
                        </div>
                    </div>
                    <!-- END No search results -->

                    <!-- BEGIN Products -->
                    <div class="col-md-6" v-repeat="product in products.data">

                        <!-- BEGIN Product -->
                        <div class="well custom-well">

                            <!-- BEGIN Product title -->
                            <strong class="product-title">
                                <a href="/product-details/@{{ product.code }}">@{{ product.code }} - @{{ product.name }}</a>
                            </strong>
                            <!-- END Product title -->

                            <!-- BEGIN Product added on -->
                            <div class="product-details">
                                <strong>{{ trans('products_manager.added_on') }}:</strong> @{{ product.created_at }}
                            </div>
                            <!-- END Product added on -->
                        </div>
                        <!-- END Product -->

                    </div>
                    <!-- END Products -->
                </div>

                @include('admin-center.products-manager.partials._pagination')

            </div>
            <!-- END Content -->

        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/products.js"></script>
    <script src="/js/header-search.js"></script>
@endsection