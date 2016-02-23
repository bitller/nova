<!-- BEGIN Discount column -->
<th class="text-center" v-show="bill.show_discount_column">
    <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.discount_column_description') }}">
        {{ trans('bill.discount') }}
    </span>
</th>
<!-- END Discount column -->