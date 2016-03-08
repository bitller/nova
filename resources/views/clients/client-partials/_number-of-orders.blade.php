<!-- BEGIN Client number of orders -->
<span>
    <span>{{ trans('clients.number_of_orders') }}:</span>
    <span v-show="client.total_bills">@{{ client.total_bills }}</span>
    <span v-show="!client.total_bills"></span>
</span>
<!-- END Client number of orders -->