<!-- BEGIN Add application product modal -->
<div id="add-application-product-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('products_manager.add_application_product')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                @include('includes.modals.admin-center.products-manager.add-application-product.partials._product-name')
                @include('includes.modals.admin-center.products-manager.add-application-product.partials._product-code')
                @include('includes.modals.admin-center.products-manager.add-application-product.partials._not-used-product-name')

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled : checking_product_code">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-on="click: addApplicationProduct" v-attr="disabled : checking_product_code || !checked">
                    <span v-show="checking_product_code" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!checking_product_code">{{ trans('common.save') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Add application product modal -->