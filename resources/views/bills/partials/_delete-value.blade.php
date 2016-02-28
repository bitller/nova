<!-- BEGIN Delete bill -->
<td class="text-center vert-align">

    <!-- BEGIN Button -->
    <button class="btn btn-default" v-on="click: deleteBill(bill.id, bills.current_page, bills.to-bills.from,'{{ trans('common.loading') }}')">
        <span class="glyphicon glyphicon-trash"></span>
        {{ trans('common.delete') }}
    </button>
    <!-- END Button -->

</td>
<!-- END Delete bill -->