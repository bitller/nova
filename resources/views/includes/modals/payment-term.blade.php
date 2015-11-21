<!-- BEGIN Set payment term modal -->
<div id="payment-term-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-on="click: resetSetPaymentTermModal()" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('bill.set_payment_term') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <div class="form-group">
                    <label for="payment-term">{{ trans('bill.set_payment_term_description') }}:</label>
                    <input type="text" v-attr="value:payment_term" class="form-control" id="payment-term" placeholder="{{ trans('bill.set_payment_term_placeholder') }}">
                </div>

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-on="click: resetOtherDetailsModal()" v-attr="disabled : loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-on="click: setPaymentTerm()" v-attr="disabled : loading">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('common.save') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Set payment term modal -->