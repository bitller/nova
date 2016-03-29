<!-- BEGIN Empty bill alert -->
<div class="alert alert-block alert-info" v-show="total === '0.00'">

    <div class="row">
        <div class="col-md-1">
            <img class="img-responsive center-responsive-image" src="/img/mail.svg">
        </div>
        <div class="col-md-11 alert-col">
                <span>
                    <span>{{ trans('bill.empty_bill') }}</span>
                    <a href="#" data-target="#help-modal-how-to-add-product-to-bill" data-toggle="modal">{{ trans('bill.click_here_to_see_how_to_add_a_product') }}</a>

                </span>
        </div>
    </div>

</div>
<!-- END Empty bill alert -->