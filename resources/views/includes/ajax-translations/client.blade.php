@extends('includes.ajax-translations.common')

@section('trans')
<div id="client-trans"
     loading="{{ trans('common.loading') }}"
     client-id="{{ $clientId }}">
</div>
@endsection