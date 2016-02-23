<!-- BEGIN Mark as paid -->
<li v-show="paid < 1">
    <a href="#" v-on="click: markAsPaid()">
        <span class="glyphicon glyphicon-ok"></span> {{ trans('bill.mark_as_paid') }}
    </a>
</li>
<!-- END Mark as paid -->