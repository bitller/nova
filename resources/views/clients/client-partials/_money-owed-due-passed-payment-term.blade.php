<!-- BEGIN Money owed due passed payment term -->
<div class="col-md-12" v-show="money_owed_due_passed_payment_term">
    <div class="alert alert-warning">
        <strong>
            @{{ money_owed_due_passed_payment_term }}
            <a class="clients-link-underline" href="/clients/{{ $clientId }}/bills/unpaid">{{ trans('clients.view_all_unpaid_bills') }}</a>
        </strong>
    </div>
</div>
<!-- END Money owed due passed payment term -->