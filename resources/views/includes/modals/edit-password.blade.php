<!-- BEGIN Edit password modal -->
<div id="edit-password-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-on="click: resetPasswordModal()">&times;</button>
                <h4 class="modal-title">{{ trans('settings.change_account_password') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <!-- BEGIN Current password -->
                <div class="form-group">
                    <label for="password">{{ trans('settings.current_password') }}:</label>
                    <input id="password" type="password" class="form-control" v-model="password" />
                </div>
                <!-- END Current password -->

                <!-- BEGIN New password -->
                <div class="form-group">
                    <label for="new-password">{{ trans('settings.new_password') }}:</label>
                    <input id="new-password" type="password" class="form-control" v-model="new_password" />
                </div>
                <!-- END New password -->

                <!-- BEGIN Confirm password -->
                <div class="form-group">
                    <label for="confirm-password">{{ trans('settings.confirm_password') }}:</label>
                    <input id="confirm-password" type="password" class="form-control" v-model="confirm_password" />
                </div>
                <!-- END Confirm password -->

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-on="click: resetEditPasswordModal()" v-attr="disabled: loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-on="click: editPassword()" v-attr="disabled: loading">{{ trans('common.save') }}</button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit password modal -->