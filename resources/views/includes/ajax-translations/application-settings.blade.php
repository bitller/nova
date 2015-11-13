@extends('includes.ajax-translations.common')
@section('trans')
<div id="application-settings-trans"
    displayed-bills="{{ trans('application_settings.displayed_bills') }}"
    edit-displayed-bills="{{ trans('application_settings.edit_displayed_bills') }}"
    displayed-bills-required="{{ trans('application_settings.displayed_bills_required') }}"
    displayed-clients="{{ trans('application_settings.displayed_clients') }}"
    edit-displayed-clients="{{ trans('application_settings.edit_displayed_clients') }}"
    displayed-clients-required="{{ trans('application_settings.displayed_clients_required') }}"
    displayed-products="{{ trans('application_settings.displayed_products') }}"
    edit-displayed-products="{{ trans('application_settings.edit_displayed_products') }}"
    displayed-products-required="{{ trans('application_settings.displayed_products_required') }}"
    displayed-custom-products="{{ trans('application_settings.displayed_custom_products') }}"
    edit-displayed-custom-products="{{ trans('application_settings.edit_displayed_custom_products') }}"
    displayed-custom-products-required="{{ trans('application_settings.displayed_custom_products_required') }}"
    recover-code-valid-time="{{ trans('application_settings.recover_code_valid_time') }}"
    recover-code-valid-time-description="{{ trans('application_settings.recover_code') }}"
    recover-code-required="{{ trans('application_settings.recover_code_required') }}"
    recover-code-updated="{{ trans('application_settings.recover_code_updated') }}"
    login-attempts-allowed="{{ trans('application_settings.login_attempts_allowed') }}"
    login-attempts="{{ trans('application_settings.login_attempts') }}"
    number-of-login-attempts-required="{{ trans('application_settings.number_of_login_attempts_required') }}"
    ></div>
@endsection