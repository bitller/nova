<!-- BEGIN Change user password modal -->
<div id="create-new-offer-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('offers.create_new_offer') }}</h4>
            </div>
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
                    <input id="offer-name" type="text" class="form-control" v-on="keyup: createNewOffer | key 13" v-model="offer_name" />
                    <i class="glyphicon glyphicon-list-alt form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.plan_name">@{{ errors.plan_name }}</span>
                </div>
                <!-- END Offer name -->

                <!-- BEGIN Offer amount -->
                <div class="form-group has-feedback" v-class="has-error : errors.offer_amount">
                    <label for="offer-amount">{{ trans('offers.amount') }}:</label>
                    <input id="offer-amount" type="text" class="form-control" v-on="keyup: createNewOffer | key 13" v-model="offer_amount" />
                    <i class="glyphicon glyphicon-euro form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.plan_amount">@{{ errors.plan_amount }}</span>
                </div>
                <!-- END Offer amount -->

                <!-- BEGIN Promo code -->
                <div class="form-group has-feedback" v-class="has-error : errors.promo_code">
                    <label for="promo-code">{{ trans('offers.promo_code') }}:</label>
                    <input id="promo-code" type="text" class="form-control" v-on="keyup: createNewOffer | key 13" v-model="promo_code" />
                    <i class="glyphicon glyphicon-gift form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.promo_code">@{{ errors.promo_code }}</span>
                </div>
                <!-- END Promo code -->

                <!-- BEGIN Use this offer on sign up -->
                <div class="checkbox">
                    <label><input type="checkbox" v-model="use_on_sign_up" />{{ trans('offers.use_this_offer_on_sign_up') }}</label>
                    <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('offers.use_this_offer_on_sign_up_info') }}">?</span>
                </div>
                <!-- END Use this offer on sign up -->

                <!-- BEGIN Enable offer -->
                <div class="checkbox">
                    <label><input type="checkbox" v-model="enable_offer" />{{ trans('offers.enable_offer') }}</label>
                    <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('offers.enable_offer_info') }}">?</span>
                </div>
                <!-- END Enable offer -->

                <div class="divider"></div>

                <!-- BEGIN User password -->
                <div class="form-group has-feedback" v-class="has-error : errors.user_password">
                    <label for="user-password">{{ trans('offers.your_password') }}:</label>
                    <input id="user-password" type="password" class="form-control" v-on="keyup: createNewOffer | key 13" v-model="user_password" />
                    <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.user_password">@{{ errors.user_password }}</span>
                </div>
                <!-- END User password -->
            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled : loading">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-on="click: createNewOffer" v-attr="disabled : loading">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('common.save') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Change user password modal -->