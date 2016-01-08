<!-- BEGIN Use offer on sign up modal -->
<div id="use-offer-on-sign-up-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('offers.use_this_offer_on_sign_up')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <div class="alert alert-info">
                    {{ trans('offers.to_use_offer_password_required') }}
                </div>

                <div class="divider"></div>

                @include('includes.modals.partials.user-password-input', ['onEnter' => 'useOfferOnSignUp'])
            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'useOfferOnSignUp'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Use offer on sign up modal -->