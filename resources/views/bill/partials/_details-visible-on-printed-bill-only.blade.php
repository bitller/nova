<!-- BEGIN Details displayed only on printed bills -->
<div class="printed-details visible-print">

    <!-- BEGIN Payment term -->
    <div class="parent">
        <div>{{ trans('bill.payment_term') }}:</div>
        <div v-show="payment_term">@{{ payment_term }}</div>
        <div v-show="!payment_term">{{ trans('bill.not_set') }}</div>
    </div>
    <!-- END Payment term -->

    <!-- BEGIN To pay -->
    <div class="center parent">
        <div>{{ trans('bill.to_pay') }}:</div>
        <div>@{{ to_pay }} ron</div>
    </div>
    <!-- END To pay -->

    <!-- BEGIN Saved money -->
    <div class="parent" v-show="saved_money">
        <div>{{ trans('bill.saved_money') }}:</div>
        <div>@{{ saved_money }} ron</div>
    </div>
    <!-- END Saved money -->

    <!-- BEGIN Number of products -->
    <div class="parent" v-show="!saved_money">
        <div>{{ trans('bill.number_of_products') }}:</div>
        <div>@{{ number_of_products }}</div>
    </div>
    <!-- END Number of products -->
</div>
<!-- END Details displayed only on printed bills -->