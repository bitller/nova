<!-- BEGIN Bill total price -->
<div class="well well-sm custom-well col-md-2 text-center hidden-print bill-normal-text-color" v-show="total !== '0.00'">
    <span class="text-center">{{ trans('bill.to_pay') }}: <strong>@{{ to_pay }} ron</strong></span>
</div>
<!-- END Bill total price -->