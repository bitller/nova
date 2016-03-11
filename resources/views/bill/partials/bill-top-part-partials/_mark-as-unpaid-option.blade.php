<!-- BEGIN Mark as unpaid -->
<li v-show="paid > 0">
    <a href="#" v-on="click: markAsUnpaid()">
        <span class="dropdown-option">
            <span class="glyphicon glyphicon-remove"></span>&nbsp; {{ trans('bill.mark_as_unpaid') }}
        </span>
    </a>
</li>
<!-- END Mark as unpaid -->