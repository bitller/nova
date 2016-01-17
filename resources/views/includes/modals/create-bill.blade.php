<!-- BEGIN Create bill modal -->
<div id="create-bill-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('bills.create') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div class="col-md-12" v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <!-- BEGIN Client name -->
                <div role="form" class="col-md-12">
                    <div class="form-group has-feedback client-name">
                        <label for="client-name">{{ trans('bills.client_name') }}:</label>
                        <input v-on="keyup:createBill | key 13" type="text" class="twitter-typeahead form-control" id="client-name" v-model="clientName">
                        <i class="glyphicon glyphicon-refresh glyphicon-spin form-control-feedback add-product-to-bill-loader"></i>
                    </div>
                </div>
                <!-- END Client name -->

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled: loading" v-on="click: resetCreateBillModal()">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-attr="disabled: loading" v-on="click: createBill()">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('bills.create') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Create bill modal -->