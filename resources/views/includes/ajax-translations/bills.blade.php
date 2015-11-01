@extends('includes.ajax-translations.common')
@section('trans')
<div id="bills-trans"
    bill-will-be-deleted="{{ trans('bill.bill_will_be_deleted') }}"
    create-button="{{ trans('bills.create') }}"
    ></div>
@endsection