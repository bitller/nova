<!-- BEGIN Is offer enabled modal modal -->
<div id="is-offer-enabled-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('offers.offer_status')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <div class="checkbox">
                    <label><input type="checkbox" v-model="enable_offer" />{{ trans('offers.enable_offer') }}</label>
                    <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('offers.enable_offer_info') }}">?</span>
                </div>

                <div class="divider"></div>

                @include('includes.modals.partials.user-password-input', ['onEnter' => 'isOfferEnabled'])
            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'isOfferEnabled'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Use offer on sign up modal -->