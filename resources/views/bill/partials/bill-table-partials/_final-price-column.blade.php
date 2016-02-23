<!-- BEGIN Final price column -->
<th class="text-center" v-show="bill.show_discount_column">
    <span data-toggle="tooltip" data-placement="top" title="{{ trans('bill.final_price_column_description') }}">
        {{ trans('bill.final_price') }}
    </span>
</th>
<!-- END Final price column -->