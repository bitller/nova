<!-- BEGIN Edit user email modal -->
<div id="edit-user-email-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('users_manager.edit_email') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <div class="form-group has-feedback">
                    <label for="user-email">{{ trans('users_manager.email') }}:</label>
                    <input id="user-email" type="text" class="form-control" v-on="keyup: editUserEmail | key 13" v-model="email" />
                    <i class="glyphicon glyphicon-envelope form-control-feedback icon-color"></i>
                </div>

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled : loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-on="click: editUserEmail" v-attr="disabled : loading">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('common.save') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit user email modal -->