<!-- BEGIN Bill total discount -->
<div class="well well-sm custom-well col-md-3 text-center hidden-print" v-show="total !== '0.00'">
    <span v-show="saved_money">{{ trans('bill.saved_money') }}: <strong>@{{ saved_money }} ron</strong></span>
    <span v-show="!saved_money">{{ trans('bill.number_of_products') }}: <strong>@{{ number_of_products }}</strong></span>
</div>
<!-- END Bill total discount -->