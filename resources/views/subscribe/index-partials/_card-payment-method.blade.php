<!-- BEGIN Credit card subscription -->
<div class="col-sm-12 col-md-6 col-lg-6">

    <!-- BEGIN Payment method well -->
    <div class="well custom-well payment-well payment-well-selected">

        <!-- BEGIN Credit card icon -->
        <div class="glyphicon glyphicon-credit-card icon"></div>
        <!-- END Credit card icon -->

        <!-- BEGIN Payment method title -->
            <span class="payment-method-title">
                <strong>&nbsp;Plata cu cardul</strong>
            </span>
        <!-- END Payment method title -->

        <div class="grey-text price">
            <h1>19.99</h1>
            <h4>ron/luna</h4>
        </div>

        <!-- BEGIN Choose this method -->
        <a href="/create-subscription/card">
            <div class="btn btn-primary">
                <strong>{{ trans('subscribe.choose_this_method') }}</strong>
            </div>
        </a>
        <!-- END Choose this method -->

        <div class="divider"></div>

        <!-- BEGIN Method description -->
        <div class="grey-text">
            {{ trans('subscribe.credit_card_method_description') }}
        </div>
        <!-- END Method description -->

    </div>
    <!-- END Payment well -->

</div>
<!-- END Credit card subscription -->