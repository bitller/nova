<!-- BEGIN Mark as unpaid -->
<li v-show="paid > 0">
    <a href="#" v-on="click: markAsUnpaid()">
        <span class="glyphicon glyphicon-remove"></span> {{ trans('bill.mark_as_unpaid') }}
    </a>
</li>
<!-- END Mark as unpaid -->