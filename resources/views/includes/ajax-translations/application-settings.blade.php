@extends('includes.ajax-translations.common')
@section('trans')
<div id="application-settings-trans"
    displayed-bills="{{ trans('application_settings.displayed_bills') }}"
    edit-displayed-bills="{{ trans('application_settings.edit_displayed_bills') }}"
    displayed-bills-required="{{ trans('application_settings.displayed_bills_required') }}"
    displayed-clients="{{ trans('application_settings.displayed_clients') }}"
    edit-displayed-clients="{{ trans('application_settings.edit_displayed_clients') }}"
    displayed-clients-required="{{ trans('application_settings.displayed_clients_required') }}"
    ></div>
@endsection