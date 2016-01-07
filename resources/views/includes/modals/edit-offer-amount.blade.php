<!-- BEGIN Edit offer amount modal -->
<div id="edit-offer-amount-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('offers.edit_offer_amount')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Offer amount -->
                <div class="form-group has-feedback" v-class="has-error : errors.offer_amount">
                    <label for="offer-amount">{{ trans('offers.amount') }}:</label>
                    <input id="offer-amount" type="text" class="form-control" placeholder="@{{ offer.amount }}" v-on="keyup: editOfferAmount | key 13" v-model="offer_amount" />
                    <i class="glyphicon glyphicon-usd form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.offer_amount">@{{ errors.offer_amount }}</span>
                </div>
                <!-- END Offer name -->

                <div class="divider"></div>

                @include('includes.modals.partials.user-password-input', ['onEnter' => 'editOfferAmount'])
            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'editOfferAmount'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit offer amount modal -->