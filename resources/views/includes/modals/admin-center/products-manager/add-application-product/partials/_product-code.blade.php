<!-- BEGIN Product code -->
<div class="form-group has-feedback" v-class="has-error : errors.product_code">

    <!-- BEGIN Product code title -->
    <label for="product-code">
        {{ trans('products_manager.product_code') }}
        <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('products_manager.product_code_tooltip') }}">?</span>
    </label>
    <!-- END Product code title -->

    <!-- BEGIN Product code input -->
    <input v-model="product_code" id="product-code" type="text" class="form-control" placeholder="{{ trans('products_manager.product_code_placeholder') }}" />
    <div v-show="errors.product_code" class="text-danger">@{{ errors.product_code }}</div>
    <!-- END Product code input -->

    <!-- BEGIN Check product code link -->
    <a href="#" v-on="click: checkIfProductCodeIsUsed(undefined)">
        <span class="grey-text check-code-link">
            <strong>{{ trans('products_manager.check_if_code_is_used') }}</strong>
        </span>
    </a>
    <!-- END Check product code link -->

    <!-- BEGIN Product code used warning -->
    <div v-show="!checking_product_code && checked && product_used && !other_product_checked && !other_product_used" class="alert alert-warning">
        {{ trans('products_manager.product_code_used_warning') }}
    </div>
    <!-- END Product code used warning -->

    <!-- BEGIN Valid product code alert -->
    <div v-show="!checking_product_code && checked && !product_used" class="alert alert-success">
        {{ trans('products_manager.product_code_is_valid') }}
    </div>
    <!-- END Valid product code alert -->

</div>
<!-- END Product code -->