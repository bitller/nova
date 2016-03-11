<!-- BEGIN Mark as paid -->
<li v-show="paid < 1">
    <a href="#" v-on="click: markAsPaid()">
        <span class="dropdown-option">
            <span class="glyphicon glyphicon-ok"></span>&nbsp; {{ trans('bill.mark_as_paid') }}
        </span>
    </a>
</li>
<!-- END Mark as paid -->