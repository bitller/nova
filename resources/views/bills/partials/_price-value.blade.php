<!-- BEGIN Price -->
<td class="text-center vert-align">
    <span v-show="bill.final_price > 0">@{{ bill.final_price }} ron</span>
    <span v-show="bill.final_price < 1">0 ron</span>
</td>
<!-- END Price -->