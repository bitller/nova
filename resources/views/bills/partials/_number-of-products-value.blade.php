<!-- BEGIN Number of products -->
<td class="text-center vert-align">
    <span v-show="bill.number_of_products > 0">@{{ bill.number_of_products }}</span>
    <span v-show="bill.number_of_products < 1">0</span>
</td>
<!-- END Number of products -->