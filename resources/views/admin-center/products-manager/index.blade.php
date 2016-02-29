@extends('layout.index')
@section('content')

    <!-- BEGIN Products manager -->
    <div id="products-manager-index" class="well custom-well-with-no-padding">

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
                        {{ trans('products_manager.there_are') }} 104 {{ trans('products_manager.products') }}.
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
            <div class="application-products">
                <div class="row">

                    <div class="col-md-6">
                        <div class="well custom-well">

                            <strong class="product-title">
                                <a href="#">00212 - ceas asier</a>
                            </strong>

                            <div class="product-details">
                                <strong>{{ trans('products_manager.added_on') }}:</strong> 20-02-2016
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="well custom-well">

                            <strong class="product-title">
                                <a href="#">00212 - ceas asier</a>
                            </strong>

                            <div class="product-details">
                                <strong>{{ trans('products_manager.added_on') }}:</strong> 20-02-2016
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="well custom-well">

                            <strong class="product-title">
                                <a href="#">00212 - ceas asier</a>
                            </strong>

                            <div class="product-details">
                                <strong>{{ trans('products_manager.added_on') }}:</strong> 20-02-2016
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="well custom-well">

                            <strong class="product-title">
                                <a href="#">00212 - ceas asier</a>
                            </strong>

                            <div class="product-details">
                                <strong>{{ trans('products_manager.added_on') }}:</strong> 20-02-2016
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- END Application product -->

            @include('admin-center.products-manager.partials._pagination')

        </div>
    </div>
    <!-- END Products manager -->
@endsection

@section('scripts')

@endsection