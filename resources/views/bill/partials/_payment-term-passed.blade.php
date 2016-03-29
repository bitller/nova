<!-- BEGIN Payment term passed alert -->
<div v-show="payment_term_passed" class="alert alert-danger">

    <div class="row">
        <div class="col-md-1">
            <img class="img-responsive center-responsive-image" src="/img/caution.svg">
        </div>
        <div class="col-md-11 alert-col">
            <span>
                {{ trans('bill.payment_term_passed') }}
            </span>
        </div>
    </div>

</div>
<!-- END Payment term passed alert -->