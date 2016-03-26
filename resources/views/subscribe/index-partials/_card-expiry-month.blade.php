<!-- BEGIN Card expiry month -->
<div class="col-sm-12 col-md-6 col-lg-6">

    <!-- BEGIN Form group -->
    <div class="form-group" v-class="has-error : card_expiry_date_error">

        <!-- BEGIN Expiry month label -->
        <label for="card-expiry-month" class="grey-text">
            {{ trans('subscribe.expiry_month') }}
        </label>
        <!-- END Expiry month label -->

        <input type="text" class="form-control" v-model="card_expiry_month" id="card-expiry-month">
        <span class="text-danger" v-show="card_expiry_date_error">@{{ card_expiry_date_error }}</span>
    </div>
    <!-- END Form group -->

</div>
<!-- END Card expiry month -->