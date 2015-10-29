@extends('includes.ajax-translations.common')

@section('trans')
<div id="client-trans"
     loading="{{ trans('common.loading') }}"
     {{--client-id="{{ $clientId }}"--}}
     client-will-be-deleted="{{ trans('clients.client_will_be_deleted') }}"
     client-deleted="{{ trans('clients.client_deleted') }}"
>
</div>
@endsection