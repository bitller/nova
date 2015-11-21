<!-- BEGIN Add product modal -->
<div id="addProductToBillModal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('bill.add_product_bill') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div class="col-md-12" v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <!-- BEGIN Product code input -->
                <div role="form" class="col-md-12">
                    <div class="form-group has-feedback product-code" v-class="has-error : errors.product_code">
                        <label for="product-code">{{ trans('bill.product_code') }}:</label>
                        <input type="text" class="twitter-typeahead form-control" id="product-code" placeholder="Ex: 20401" v-model="code">
                        <i class="glyphicon glyphicon-refresh glyphicon-spin form-control-feedback add-product-to-bill-loader"></i>
                        <span class="text-danger" v-show="errors.product_code">@{{ errors.product_code }}</span>
                    </div>
                </div>
                <!-- END Product code input -->

                <!-- BEGIN Product page and product price inputs -->
                <div role="form" class="col-md-6">
                    <div class="form-group" v-class="has-error : errors.product_price">
                        <label for="product-price">{{ trans('bill.product_price') }}:</label>
                        <input type="text" class="form-control" id="product-price" placeholder="Ex: 25.50" v-model="price">
                        <span class="text-danger" v-show="errors.product_price">@{{ errors.product_price }}</span>
                    </div>
                    <div class="form-group" v-class="has-error : errors.product_page">
                        <label for="product-page">{{ trans('bill.product_page') }}:</label>
                        <input type="text" class="form-control" id="product-page" placeholder="Ex: 156" v-model="page">
                        <span class="text-danger" v-show="errors.product_page">@{{ errors.product_page }}</span>
                    </div>
                </div>
                <!-- END Product page and product price inputs -->

                <!-- BEGIN Product discount and product quantity inputs -->
                <div role="form" class="col-md-6">
                    <div class="form-group" v-class="has-error : errors.product_discount">
                        <label for="product-discount">{{ trans('bill.product_discount') }}:</label>
                        <input type="text" class="form-control" id="product-discount" placeholder="Ex: 25" v-model="discount">
                        <span class="text-danger" v-show="errors.product_discount">@{{ errors.product_discount }}</span>
                    </div>
                    <div class="form-group" v-class="has-error : errors.product_quantity">
                        <label for="product-quantity">{{ trans('bill.product_quantity') }}:</label>
                        <input type="text" class="form-control" id="product-quantity" placeholder="Ex: 2" v-model="quantity">
                        <span class="text-danger" v-show="errors.product_quantity">@{{ errors.product_quantity }}</span>
                    </div>
                </div>
                <!-- END Product discount and product quantity inputs -->

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled: loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-attr="disabled: loading" v-on="click: addProduct()">@{{ add_product }}</button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Add product modal -->