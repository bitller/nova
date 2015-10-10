<!-- BEGIN Add product modal -->
<div id="addProductToBillModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-on="click: resetModal()">&times;</button>
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
                    <div class="form-group">
                        <label for="product-code">{{ trans('bill.product_code') }}:</label>
                        <input type="text" class="twitter-typeahead form-control" id="product-code" placeholder="Ex: 20401" v-model="code">
                    </div>
                </div>
                <!-- END Product code input -->

                <!-- BEGIN Product page and product price inputs -->
                <div role="form" class="col-md-6">
                    <div class="form-group">
                        <label for="product-page">{{ trans('bill.product_page') }}:</label>
                        <input type="text" class="form-control" id="product-page" placeholder="Ex: 156" v-model="page">
                    </div>
                    <div class="form-group">
                        <label for="product-price">{{ trans('bill.product_price') }}:</label>
                        <input type="text" class="form-control" id="product-price" placeholder="Ex: 25.50" v-model="price">
                    </div>
                </div>
                <!-- END Product page and product price inputs -->

                <!-- BEGIN Product discount and product quantity inputs -->
                <div role="form" class="col-md-6">
                    <div class="form-group">
                        <label for="product-discount">{{ trans('bill.product_discount') }}:</label>
                        <input type="text" class="form-control" id="product-discount" placeholder="Ex: 25" v-model="discount">
                    </div>
                    <div class="form-group">
                        <label for="product-quantity">{{ trans('bill.product_quantity') }}:</label>
                        <input type="text" class="form-control" id="product-quantity" placeholder="Ex: 2" v-model="quantity">
                    </div>
                </div>
                <!-- END Product discount and product quantity inputs -->

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-on="click: resetModal()">Close</button>
                <button type="button" class="btn btn-primary" v-on="click: addProduct()">Add product</button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Add product modal -->