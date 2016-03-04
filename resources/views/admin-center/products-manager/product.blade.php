@extends('layout.index')
@section('content')
@include('includes.ajax-translations.common')

    <!-- BEGIN Products manager -->
    <div id="products-manager-product" product-id="{{ $productId }}" product-code="{{ $productCode }}" class="well custom-well-with-no-padding" v-show="loaded">

    <div>
        <!-- BEGIN Top part -->
        <div class="top-part">

            <!-- BEGIN Page title and number of application products -->
            <div class="title-and-number-of-products">

                <!-- BEGIN Page title -->
                <div class="title">
                    @{{ product.name }} - @{{ product.code }}

                </div>
                <!-- END Page title -->

                <!-- BEGIN Added on -->
                <div class="number-of-application-products">
                    {{ trans('products_manager.added_on') }} @{{ product.created_at.date }}
                </div>
                <!-- END Added on -->

            </div>
            <!-- END Page title and number of application products -->

            @include('includes.admin-center.buttons.more-options-dropdown', [
                'class' => 'pull-right',
                'text' => trans('products_manager.options'),
                'items' => [
                    [
                        'name' => trans('products_manager.edit_product_name'),
                        'url' => '/',
                        'icon' => 'glyphicon-pencil'
                    ]
                ]
            ])

        </div>
        <!-- END Top part -->

        <div class="primary-divider">
            {{ trans('products_manager.more_details') }}
        </div>

        <!-- BEGIN Application product -->
        <div class="application-products" style="background-color: #F6F7F8">

            <div class="row">

                <!-- BEGIN Used by x users -->
                <div class="col-md-6">
                    <div class="well custom-well grey-text">
                        <strong>@{{ product.number_of_users_that_use_this_product }}</strong>
                    </div>
                </div>
                <!-- END Used by x users -->


                <!-- BEGIN Used in x bills -->
                <div class="col-md-6">
                    <div class="well custom-well grey-text">
                        <strong>@{{ product.number_of_bills_that_use_this_product }}</strong>
                    </div>
                </div>
                <!-- END Used in x bills -->

                <!-- BEGIN Sold pieces -->
                <div class="col-md-6">
                    <div class="well custom-well grey-text">
                        <strong>@{{ product.sold_pieces }}</strong>
                    </div>
                </div>
                <!-- END Sold pieces -->

                <!-- BEGIN Generated money -->
                <div class="col-md-6">
                    <div class="well custom-well grey-text">
                        <strong>@{{ product.generated_money }}</strong>
                    </div>
                </div>
                <!-- END Generated money -->

            </div>

        </div>
        <!-- END Application product -->

    </div>
    @include('includes.modals.admin-center.products-manager.add-application-product.add-application-product')
</div>
<!-- END Products manager -->
@endsection

@section('scripts')
    <script src="/js/admin-center_products-manager_product.js"></script>
@endsection