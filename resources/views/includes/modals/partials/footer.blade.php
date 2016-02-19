<!-- BEGIN Modal footer -->
<div class="modal-footer">
    <?php if (!isset($loading)) $loading = 'loading'; ?>
    <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled : {{ $loading }}">{{ trans('common.cancel') }}</button>
    <button type="button" class="btn btn-primary" v-on="click: {{ $onClick }}" v-attr="disabled : {{ $loading }}">
        <span v-show="{{ $loading }}" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
        <span v-show="!{{ $loading }}">{{ trans('common.save') }}</span>
    </button>
</div>
<!-- END Modal footer -->