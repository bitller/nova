<!-- BEGIN Bill other details -->
<div class="panel panel-default" v-show="other_details && total !== '0.00'">
    <div class="panel-heading">{{ trans('bill.other_details') }}</div>
    <div class="panel-body">
        @{{{ other_details }}}
    </div>
</div>
<!-- END Bill other details -->