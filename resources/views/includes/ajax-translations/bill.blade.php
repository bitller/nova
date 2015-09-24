@extends('includes.ajax-translations.common')
@section('trans')
<div id="bill-trans"
    product-will-be-deleted="{{ trans('bill.product_will_be_deleted') }}"
    product-page-required="{{ trans('bill.product_page_required') }}"
    page-updated="{{ trans('bill.page_updated') }}"
    edit-page="{{ trans('bill.edit_page') }}"
    edit-page-description="{{ trans('bill.edit_page_description') }}"
    edit-quantity="{{ trans('bill.edit_quantity') }}"
    edit-quantity-description="{{ trans('bill.edit_quantity_description') }}"
    product-quantity-required="{{ trans('bill.product_quantity_required') }}"
    quantity-updated="{{ trans('bill.quantity_updated') }}"
    edit-price="{{ trans('bill.edit_price') }}"
    edit-price-description="{{ trans('bill.edit_price_description') }}"
    product-price-required="{{ trans('bill.product_price_required') }}"
    price-updated="{{ trans('bill.price_updated') }}"
    edit-discount="{{ trans('bill.edit_discount') }}"
    edit-discount-description="{{ trans('bill.edit_discount_description') }}"
    product-discount-required="{{ trans('bill.product_discount_required') }}"
    discount-updated="{{ trans('bill.discount_updated') }}"
    ></div>
@endsection