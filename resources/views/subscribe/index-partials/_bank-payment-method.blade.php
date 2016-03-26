<!-- BEGIN Bank subscription -->
<div class="col-sm-12 col-md-6 col-lg-6">

    <!-- BEGIN Payment method well -->
    <div class="well custom-well payment-well payment-well-selected">

        <!-- BEGIN Bank icon -->
        <div class="glyphicon glyphicon-piggy-bank icon"></div>
        <!-- END Bank icon -->

        <!-- BEGIN Payment method title -->
            <span class="payment-method-title">
                <strong>&nbsp;Plata prin transfer bancar</strong>
            </span>
        <!-- END Payment method title -->

        <!-- BEGIN Price -->
        <div class="grey-text price">
            <h1>19.99</h1>
            <h4>ron/luna</h4>
        </div>
        <!-- END Price -->

        <!-- BEGIN Choose this method -->
        <a href="/create-subscription/bank">
            <div class="btn btn-primary">
                <strong>{{ trans('subscribe.choose_this_method') }}</strong>
            </div>
        </a>
        <!-- END Choose this method -->

        <div class="divider"></div>

        <!-- BEGIN Method description -->
        <div class="grey-text">
            {{ trans('subscribe.bank_method_description') }}
        </div>
        <!-- END Method description -->

    </div>
    <!-- END Payment well -->

</div>
<!-- END Bank subscription -->