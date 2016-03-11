<!-- BEGIN Add product modal -->
<div id="other-details-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('bill.other_details') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                {{--<div class="form-group">--}}
                    {{--<label for="other-details">{{ trans('bill.add_bill_other_details') }}:</label>--}}
                    {{--<textarea v-model="otherDetails" name="other-details" id="other-details" class="form-control" rows="6">@{{ other_details }}</textarea>--}}
                {{--</div>--}}
                <div id="summernote">Hello Summernote</div>

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-on="click: resetOtherDetailsModal()" v-attr="disabled : loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-on="click: saveOtherDetails()" v-attr="disabled : loading">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('common.save') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Add product modal -->