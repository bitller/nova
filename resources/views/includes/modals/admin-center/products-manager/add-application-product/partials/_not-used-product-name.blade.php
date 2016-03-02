<!-- BEGIN Not used product code to replace current one if is used -->
<div v-show="checked && product_used" class="form-group">

    <!-- BEGIN Other product code label -->
    <label for="not-used-product-code">
        <span>{{ trans('products_manager.other_product_code') }}</span>
        <span class="badge" data-placement="right" title="{{ trans('products_manager.other_product_code_tooltip') }}" data-toggle="tooltip">?</span>
    </label>
    <!-- END Other product code label -->

    <input v-model="other_product_code" id="not-used-product-code" type="text" class="form-control" placeholder="{{ trans('products_manager.not_used_product_code_placeholder') }}" />

    <a href="#" v-on="click: checkIfOtherProductCodeIsUsed">
        <span class="grey-text check-code-link">
            <strong>{{ trans('products_manager.check_if_code_is_used') }}</strong>
        </span>
    </a>

    <div v-show="!other_product_used && other_product_checked" class="alert alert-success">
        {{ trans('products_manager.other_product_code_available') }}
    </div>

    <div v-show="other_product_used && other_product_checked" class="alert alert-warning">
        {{ trans('products_manager.other_product_code_used') }}
    </div>

</div>
<!-- END Not used product code to replace current one if is used -->