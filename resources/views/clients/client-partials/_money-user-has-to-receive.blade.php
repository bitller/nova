<!-- BEGIN Money user has to receive -->
<div class="col-md-12" v-show="money_user_has_to_receive">
    <div class="alert alert-success">
        <strong>
            @{{ money_user_has_to_receive }}
            <a href="/clients/{{ $clientId }}/bills/unpaid">{{ trans('clients.view_all_unpaid_bills') }}</a>
        </strong>
    </div>
</div>
<!-- END Money user has to receive -->