<!-- BEGIN Card number -->
<div class="col-sm-12 col-md-6 col-lg-6">

    <!-- BEGIN Form group -->
    <div class="form-group" v-class="has-error : card_number_error">

        <!-- BEGIN Card number label -->
        <label for="card-number" class="grey-text">
            {{ trans('subscribe.card_number') }}
        </label>
        <!-- END Card number label -->

        <input type="text" class="form-control" v-model="card_number" id="card-number">
        <span class="text-danger" v-show="card_number_error">@{{ card_number_error }}</span>
    </div>
    <!-- END Form group -->

</div>
<!-- END Card number -->