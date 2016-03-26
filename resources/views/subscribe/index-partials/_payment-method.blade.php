<!-- BEGIN Payment method -->
<div class="col-md-12">

    <!-- BEGIN Credit card subscription -->
    <div class="col-sm-12 col-md-5 col-lg-5">

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

    <!-- BEGIN Bank transfer -->
    <div class="col-sm-12 col-md-5 col-lg-5 col-sm-offset-0 col-md-offset-2 col-lg-offset-2">
        <div class="well custom-well">
            <div class="glyphicon glyphicon-piggy-bank"></div>
            <span>Plata prin transfer bancar</span>
        </div>
    </div>
    <!-- END Bank transfer -->

</div>
<!-- END Payment method -->