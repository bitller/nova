@extends('includes.ajax-translations.common')
@section('trans')
<div id="product-details-trans"
    edit-name="{{ trans('product_details.edit_name') }}"
    edit-name-description="{{ trans('product_details.edit_name_description') }}"
    name-input-required="{{ trans('product_details.product_name_input_required') }}"
></div>
@endsection