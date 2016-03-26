<!-- BEGIN Card expiry year -->
<div class="col-sm-12 col-md-6 col-lg-6">

    <!-- BEGIN Form group -->
    <div class="form-group">

        <!-- BEGIN Expiry year label -->
        <label for="card-expiry-year" class="grey-text">
            {{ trans('subscribe.expiry_year') }}
        </label>
        <!-- END Expiry year label -->

        <input type="text" class="form-control" v-model="card_expiry_year" id="card-expiry-year">
    </div>
    <!-- END Form group -->

</div>
<!-- END Card expiry year -->