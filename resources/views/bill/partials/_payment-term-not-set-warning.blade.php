<!-- BEGIN Payment term not set alert -->
<div v-show="!payment_term && total != '0.00'" class="alert alert-warning hidden-print">

    <div class="row">
        <div class="col-md-1">
            <img class="img-responsive center-responsive-image" src="/img/calendar.svg">
        </div>
        <div class="col-md-11 alert-col">
                <span>
                    {{ trans('bill.payment_term_not_set') }}.
                    <a class="warning-alert-bold-text" href="#" v-on="click: resetPaymentTermModal()" data-toggle="modal" data-target="#payment-term-modal">{{ trans('bill.set_now') }}</a>
                </span>
        </div>
    </div>

</div>
<!-- END Payment term not set alert -->