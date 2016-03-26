<!-- BEGIN Card holder -->
<div class="col-sm-12 col-md-6 col-lg-6">

    <!-- BEGIN Form group -->
    <div class="form-group" v-class="has-error : card_holder_error">

        <!-- BEGIN Card holder name label -->
        <label for="card-holdername" class="grey-text">
            {{ trans('subscribe.cardholder_name') }}
        </label>
        <!-- END Card holder name label -->

        <input type="text" class="form-control" v-model="card_holdername" id="card-holdername">
        <span class="text-danger" v-show="card_holder_error">@{{ card_holder_error }}</span>
    </div>
    <!-- END Form group -->

</div>
<!-- END Card holder -->