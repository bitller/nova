<!-- BEGIN Confirm start subscription modal -->
<div id="confirm-start-subscription-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('subscribe.confirm_start_subscription')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">


                <div class="col-md-12">
                    <strong>{{ trans('subscribe.bank_subscription_has_been_paid_confirmation') }}</strong>
                </div>

                <div class="col-md-12">
                    <span class="text-danger">
                        <strong>{{ trans('subscribe.bank_subscription_has_been_paid_confirmation_warning') }}</strong>
                    </span>
                </div>

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'startSubscription()'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Confirm start subscription modal -->