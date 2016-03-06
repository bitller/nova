@extends('layout.index')
@section('content')
    @include('includes.ajax-translations.common')
    @include('includes.ajax-translations.my-products')
    <div id="my-products" v-show="loaded">
        <div v-show="loaded">
            <div>
                <!-- BEGIN Top part -->
                <div class="ff-top-part">

                    <!-- BEGIN Page title and description -->
                    <div class="ff-title-and-description">

                        <!-- BEGIN Page title -->
                        <div class="ff-title">
                            {{ trans('my_products.my_products') }}
                        </div>
                        <!-- END Page title -->

                        <!-- BEGIN Page short description -->
                        <div class="ff-description">
                            {{ trans('my_products.page_description') }}
                        </div>
                        <!-- END Page short description -->

                    </div>
                    <!-- END Page title and description -->

                    <!-- BEGIN Add product button -->
                    <button type="button" class="btn btn-primary pull-right" data-target="#add-custom-product-modal" data-toggle="modal">
                        <span class="glyphicon glyphicon-plus"></span> {{ trans('my_products.add_product') }}
                    </button>
                    <!-- END Add product button -->

                </div>
                <!-- END Top part -->

                <!-- BEGIN Primary divider -->
                <div class="ff-primary-divider">
                    <span class="search-product pointer" v-on="click: toggleSearch">{{ trans('my_products.search_product') }}</span>
                </div>
                <!-- END Primary divider -->

                <!-- BEGIN Content -->
                <div class="ff-content">
                    <div class="row">

                        <!-- BEGIN Search application products -->
                        <div class="form-group col-md-12 search-products">
                            <input v-model="search_term" v-on="keyup:search | key 13" id="search-products-input" type="text" class="form-control" placeholder="{{ trans('products_manager.search_placeholder') }}" />
                        </div>
                        <!-- END Search application products -->

                        <!-- BEGIN Search results text -->
                        <div v-show="searched" class="col-md-12 search-results-text">
                            <strong>{{ trans('products_manager.search_results') }}:</strong>
                        </div>
                        <!-- END Search results text -->

                        <!-- BEGIN No search results -->
                        <div class="col-md-12" v-show="searched && myProducts.total < 1">
                            <div class="well custom-well no-search-results-text">
                                <strong>
                                    {{ trans('products_manager.no_search_results') }}
                                    <a href="#" v-on="click:resetSearch">{{ trans('products_manager.click_here_to_show_all_products') }}</a>
                                </strong>
                            </div>
                        </div>
                        <!-- END No search results -->

                        <!-- BEGIN Products -->
                        <div class="col-md-6" v-repeat="product in myProducts.data">

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

                    @include('my-products.partials._pagination')

                </div>
                <!-- END Content -->

            </div>

        </div>

        @include('includes.modals.add-custom-product')

    </div>
@endsection

@section('scripts')
    <script src="/js/my-products.js"></script>
@endsection