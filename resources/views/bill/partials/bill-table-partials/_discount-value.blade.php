<!-- BEGIN Product discount value -->
<td class="text-center editable" v-show="bill.show_discount_column" v-on="click: editDiscount(product.discount, product.id, product.code, product.bill_product_id)">
    @{{ product.discount }}% - @{{ product.calculated_discount }} ron
</td>
<!-- END Product discount value -->
