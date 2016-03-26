<!-- BEGIN Card cvc -->
<div class="col-sm-12 col-md-6 col-lg-6">

    <!-- BEGIN Form group -->
    <div class="form-group" v-class="has-error : card_cvc_error">

        <!-- BEGIN Cvc label -->
        <label for="card-cvc" class="grey-text">
            {{ trans('subscribe.cvc') }}
        </label>
        <!-- END Cvc label -->

        <input type="text" class="form-control" v-model="card_cvc" id="card-cvc">
        <span class="text-danger" v-show="card_cvc_error">@{{ card_cvc_error }}</span>
    </div>
    <!-- END Form group -->

</div>
<!-- END Card cvc -->