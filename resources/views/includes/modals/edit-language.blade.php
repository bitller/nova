<!-- BEGIN Edit language modal -->
<div id="edit-language-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('settings.change_language') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <div class="col-md-12 text-center" v-show="!languages_loaded">
                    <span class="glyphicon glyphicon-refresh glyphicon-spin text-center"></span>
                </div>

                <!-- BEGIN Choose language -->
                <div class="form-group" v-show="languages_loaded">
                    <label for="languages">{{ trans('settings.choose_language') }}:</label>
                    <select class="form-control" id="languages" v-model="language">
                        <option selected disabled>{{ trans('settings.choose_language') }}</option>
                        <option v-repeat="available_language in languages" value="@{{ available_language.key }}">@{{ available_ language.language }}</option>
                    </select>
                </div>
                <!-- END Choose language -->

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" v-attr="disabled: loading" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-attr="disabled: loading" v-on="click: editLanguage()">@{{ save_button }}</button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit language modal -->