<!-- BEGIN Expired subscription alert -->
<div class="alert alert-danger">
    <div class="row">
        <div class="col-md-1">
            <img class="img-responsive center-responsive-image" src="/img/caution.svg">
        </div>
        <div class="col-md-11 alert-col">
            <span>
                {{ trans('subscribe.expired_subscription') }}
                <a class="other-link-color" href="/create-subscription">{{ trans('subscribe.renew') }}</a>
            </span>
        </div>
    </div>
</div>
<!-- END Expired subscription alert -->