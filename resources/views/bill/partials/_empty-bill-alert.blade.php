<!-- BEGIN Empty bill alert -->
<div class="alert alert-block alert-info" v-show="total === '0.00'" style="vertical-align: middle;display: inline-block;">
    <i class="glyphicon glyphicon-info-sign"></i>
    <span>{{ trans('bill.empty_bill') }}</span>
    <a href="#">{{ trans('bill.click_here_to_see_how_to_add_a_product') }}</a>
</div>
<!-- END Empty bill alert -->