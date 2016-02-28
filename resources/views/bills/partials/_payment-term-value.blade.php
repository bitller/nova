<!-- BEGIN Payment term -->
<td class="text-center vert-align">
    <span v-show="bill.payment_term == '0000-00-00'">{{ trans('bill.not_set') }}</span>
    <span v-show="bill.payment_term != '0000-00-00'">@{{ bill.payment_term }}</span>
</td>
<!-- END Payment term -->