<!-- BEGIN Ask question modal -->
<div id="ask-question-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('help_center.ask_question') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <div class="alert alert-danger" v-show="error">@{{ error }}</div>

                <!-- BEGIN Loader -->
                <div class="col-md-12 text-center" v-show="!question_categories_loaded">
                    <span class="glyphicon glyphicon-refresh glyphicon-spin text-center"></span>
                </div>
                <!-- END Loader -->

                <div v-show="question_categories_loaded">
                    <!-- BEGIN Question categories -->
                    <div class="form-group" v-show="question_categories_loaded">
                        <label for="question-categories">{{ trans('help_center.choose_question_category') }}:</label>
                        <select class="form-control" id="question-categories" v-model="question_category">
                            <option selected disabled>{{ trans('help_center.choose_question_category') }}</option>
                            <option v-repeat="question_category in question_categories" value="@{{ question_category.id }}">@{{ question_category.name }}</option>
                        </select>
                    </div>
                    <!-- END Question categories -->

                    <!-- BEGIN Question title -->
                    <div class="form-group" v-class="has-error : errors.question_title">
                        <input type="text" class="form-control" placeholder="{{ trans('help_center.question_title') }}" v-model="question_title" />
                        <span class="text-danger" v-show="errors.question_title">@{{ errors.question_title }}</span>
                    </div>
                    <!-- END Question title -->

                    <!-- BEGIN Question -->
                    <div class="form-group" v-class="has-error : errors.question">
                        <textarea class="form-control" placeholder="{{ trans('help_center.question') }}" v-model="question"></textarea>
                        <span class="text-danger" v-show="errors.question">@{{ errors.question }}</span>
                    </div>
                    <!-- END Question -->
                </div>
            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled: loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-attr="disabled: loading || !question_categories_loaded" v-on="click: askQuestion()">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading"><span class="glyphicon glyphicon-send"></span>&nbsp;{{ trans('help_center.send_question') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Ask question modal -->