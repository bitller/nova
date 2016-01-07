<!-- BEGIN Change user password modal -->
<div id="edit-offer-name-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('offers.edit_offer_name')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <!-- BEGIN Offer name -->
                <div class="form-group has-feedback" v-class="has-error : errors.offer_name">
                    <label for="offer-name">{{ trans('offers.offer_name') }}:</label>
                    <input id="offer-name" type="text" class="form-control" placeholder="@{{ offer.name }}" v-on="keyup: editOfferName | key 13" v-model="offer_name" />
                    <i class="glyphicon glyphicon-list-alt form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.offer_name">@{{ errors.offer_name }}</span>
                </div>
                <!-- END Offer name -->

                <div class="divider"></div>

                @include('includes.modals.partials.user-password-input', ['onEnter' => 'editOfferName'])
            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'editOfferName'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Change user password modal -->