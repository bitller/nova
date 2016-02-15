<!-- BEGIN Add custom product modal -->
<div id="add-custom-product-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('my_products.add_product')])
                    <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Loader -->
                <div class="col-md-12 text-center" v-show="loading_modal_data">
                    <span class="glyphicon glyphicon-refresh glyphicon-spin text-center"></span>
                </div>
                <!-- END Loader -->

                <!-- BEGIN Product code -->
                <div class="form-group has-feedback" v-class="has-error : errors.code">
                    <label for="product-code">{{ trans('my_products.product_code') }} <span class="badge" data-toggle="tooltip" data-placement="top" title="{{ trans('my_products.product_code_info') }}">?</span></label>
                    <input v-model="code" v-on="keyup:addProduct | key 13" id="product-code" type="text" class="form-control" placeholder="{{ trans('my_products.product_code_example') }}">
                    <span class="text-danger" v-show="errors.code">@{{ errors.code }}</span>
                    <i class="glyphicon glyphicon-barcode form-control-feedback"></i>
                </div>
                <!-- END Product code -->

                <!-- BEGIN Product name -->
                <div class="form-group has-feedback" v-class="has-error : errors.name">
                    <label for="product-name">{{ trans('my_products.product_name') }} <span class="badge" data-toggle="tooltip" data-placement="top" title="{{ trans('my_products.product_name_info') }}">?</span></label>
                    <input v-model="name" v-on="keyup:addProduct | key 13" id="product-name" type="text" class="form-control" placeholder="{{ trans('my_products.product_name_example') }}">
                    <span class="text-danger" v-show="errors.name">@{{ errors.name }}</span>
                    <i class="glyphicon glyphicon-font form-control-feedback"></i>
                </div>
                <!-- END Product name -->

                <!-- BEGIN Add another product after -->
                <div class="checkbox">
                    <label><input type="checkbox" v-model="add_another_product">{{ trans('my_products.add_another_product') }} <span class="badge" data-toggle="tooltip" data-placement="top" title="{{ trans('my_products.add_another_product_info') }}">?</span></label>
                </div>
                <!-- END Add another product after -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'addProduct'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Add custom product modal -->