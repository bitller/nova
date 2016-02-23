<!-- BEGIN Bill payment term -->
<div class="well well-sm custom-well col-md-3 text-center hidden-print" v-show="total !== '0.00'">
    <span v-show="payment_term" class="text-center">{{ trans('bill.payment_term') }}: <strong>@{{ payment_term }}</strong></span>
    <span v-show="!payment_term" class="text-center">{{ trans('bill.payment_term_not_set') }}</span>
</div>
<!-- END Bill payment term -->