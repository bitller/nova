<!-- BEGIN Product page value -->
<td class="text-center editable"  v-on="click: editPage(product.page, product.id, product.code, product.bill_product_id)">
    <span v-show="product.page != '0'">@{{ product.page }}</span>
    <span v-show="product.page < 1">-</span>
</td>
<!-- END Product page value -->