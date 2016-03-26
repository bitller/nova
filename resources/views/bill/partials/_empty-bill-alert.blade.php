<!-- BEGIN Empty bill alert -->
<div class="alert alert-block alert-info" v-show="total === '0.00'">

    <i class="glyphicon glyphicon-info-sign"></i>

    <span>{{ trans('bill.empty_bill') }}</span>

    <a href="#" data-target="#help-modal-how-to-add-product-to-bill" data-toggle="modal">{{ trans('bill.click_here_to_see_how_to_add_a_product') }}</a>
</div>
<!-- END Empty bill alert -->