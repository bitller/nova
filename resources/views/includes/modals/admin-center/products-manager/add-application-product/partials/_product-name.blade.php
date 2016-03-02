<!-- BEGIN Product name -->
<div class="form-group" v-class="has-error : errors.product_name">
    <label for="product-name">
        {{ trans('products_manager.product_name') }}
        <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('products_manager.product_name_tooltip') }}">?</span>
    </label>
    <input v-model="product_name" id="product-name" type="text" class="form-control" placeholder="{{ trans('products_manager.product_name') }}" />
    <span class="text-danger" v-show="errors.product_name">@{{ errors.product_name }}</span>
</div>
<!-- END Product name -->