@extends('includes.ajax-translations.common')

@section('trans')
    <div id="clients-trans"
         client-will-be-deleted="{{ trans('clients.client_will_be_deleted') }}"
         client-deleted="{{ trans('clients.client_deleted') }}"
    ></div>
@endsection