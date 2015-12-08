@extends('includes.ajax-translations.common')

@section('trans')
    <div id="register-trans"
         internal-server-error="{{ trans('subscribe.internal_server_error') }}"
         payment-aborted="{{ trans('subscribe.payment_aborted') }}"
         card-number-error="{{ trans('subscribe.card_number_error') }}"
         card-expiry-date-error="{{ trans('subscribe.card_expiry_date_error') }}"
         card-cvc-error="{{ trans('subscribe.card_cvc_error') }}"
         card-holder-error="{{ trans('subscribe.card_holder_error') }}"
         email-error="{{ trans('register.email_error') }}"
         password-error="{{ trans('register.password_error') }}"
         password-confirmation-error="{{ trans('register.password_confirmation_error') }}"
         card-number-error="{{ trans('register.card_number_error') }}"
         card-expiry-date-error="{{ trans('register.card_expiry_date_error') }}"
         card-cvc-error="{{ trans('register.card_cvc_error') }}"
    ></div>
@endsection