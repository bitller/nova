<!-- BEGIN Edit offer promo code modal -->
<div id="edit-offer-promo-code-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('offers.edit_offer_promo_code')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Offer promo code -->
                <div class="form-group has-feedback" v-class="has-error : errors.promo_code">
                    <label for="offer-amount">{{ trans('offers.promo_code') }}:</label>
                    <input id="offer-amount" type="text" class="form-control" placeholder="@{{ offer.promo_code }}" v-on="keyup: editOfferPromoCode | key 13" v-model="promo_code" />
                    <i class="glyphicon glyphicon-gift form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.promo_code">@{{ errors.promo_code }}</span>
                </div>
                <!-- END Offer promo code -->

                <div class="divider"></div>

                @include('includes.modals.partials.user-password-input', ['onEnter' => 'editOfferPromoCode'])
            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'editOfferPromoCode'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit offer amount modal -->