<!-- BEGIN Create bill modal -->
<div id="add-article-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('help_center.add_article') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <div class="alert alert-danger" v-show="error">@{{ error }}</div>

                <div class="form-group" v-class="has-error : errors.article_title">
                    <input type="text" class="form-control" placeholder="{{ trans('help_center.article_title') }}" v-model="article_title" />
                    <span class="text-danger" v-show="errors.article_title">@{{ errors.article_title }}</span>
                </div>

                <div class="form-group" v-class="has-error : errors.article_content">
                    <textarea class="form-control" placeholder="{{ trans('help_center.article_content') }}" v-model="article_content"></textarea>
                    <span class="text-danger" v-show="errors.article_content">@{{ errors.article_content }}</span>
                </div>

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled: loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-attr="disabled: loading" v-on="click: addArticle()">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('help_center.add_article') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Create bill modal -->