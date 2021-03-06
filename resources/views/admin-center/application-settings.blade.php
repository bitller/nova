@extends('layout.index')
@section('content')
    @include('includes.ajax-translations.application-settings')
    <div id="application-settings" v-show="loaded">

        <!-- BEGIN Top part -->
        <div class="add-product-button row">

            <span class="admin-center-title">{{ trans('application_settings.application_settings') }}</span>&nbsp;
            <div class="btn-group pull-right">
                {{--@include('includes.admin-center.buttons.users-manager')--}}
                {{--@include('includes.admin-center.buttons.subscriptions')--}}
{{--                @include('includes.admin-center.buttons.products-manager')--}}
{{--                @include('includes.admin-center.buttons.logs')--}}
                @include('includes.admin-center.buttons.more')
            </div>
        </div>
        <!-- END Top part -->

        <!-- BEGIN Bills settings -->
        <div class="row">
            <ul class="list-group">

                <!-- BEGIN Title -->
                <li class="list-group-item active">
                    <span class="glyphicon glyphicon-list"></span>&nbsp;
                    {{ trans('application_settings.bills_settings') }}
                </li>
                <!-- END Title -->

                <!-- BEGIN Number of bills displayed -->
                <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedBills()">
                    {{ trans('application_settings.bills_displayed') }}: <strong>@{{ displayed_bills }}</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of bills displayed -->

            </ul>
        </div>
        <!-- END Bills settings -->

        <!-- BEGIN Clients settings -->
        <div class="row">
            <ul class="list-group">

                <!-- BEGIN Title -->
                <li class="list-group-item active">
                    <span class="glyphicon glyphicon-user"></span>&nbsp;
                    {{ trans('application_settings.clients_settings') }}
                </li>
                <!-- END Title -->

                <!-- BEGIN Number of clients displayed -->
                <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedClients()">
                    {{ trans('application_settings.clients_displayed') }}: <strong>@{{ displayed_clients }}</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of clients displayed -->

            </ul>
        </div>
        <!-- END Clients settings -->

        <!-- BEGIN Products settings -->
        <div class="row">
            <ul class="list-group">

                <!-- BEGIN Title -->
                <li class="list-group-item active">
                    <span class="glyphicon glyphicon-th"></span>&nbsp;
                    {{ trans('application_settings.products_settings') }}
                </li>
                <!-- END Title -->

                <!-- BEGIN Number of products displayed -->
                <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedProducts()">
                    {{ trans('application_settings.products_displayed') }}: <strong>@{{ displayed_products }}</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of products displayed -->

                <!-- BEGIN Number of application products displayed -->
                <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedCustomProducts()">
                    {{ trans('application_settings.custom_products_displayed') }}: <strong>@{{ displayed_custom_products }}</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of application products displayed -->

            </ul>
        </div>
        <!-- END Products settings -->

        <!-- BEGIN Security settings -->
        <div class="row">
            <ul class="list-group">

                <!-- BEGIN Title -->
                <li class="list-group-item active">
                    <span class="glyphicon glyphicon-lock"></span>&nbsp;
                    {{ trans('application_settings.security_settings') }}
                </li>
                <!-- END Title -->

                <!-- BEGIN How many minutes recover code is valid -->
                <a href="#" class="list-group-item" v-on="click: editRecoverCodeValidTime()">
                    {{ trans('application_settings.recover_code') }}: <strong>@{{ recover_code_valid_minutes }} {{ trans('application_settings.minutes') }}</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END How many minutes recover code is valid -->

                <!-- BEGIN Number of allowed consecutive login attempts -->
                <a href="#" class="list-group-item" v-on="click: editAllowedLoginAttempts()">
                    {{ trans('application_settings.login_attempts') }}: <strong>@{{ login_attempts }}</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of allowed consecutive login attempts -->

                <!-- BEGIN Allow new accounts -->
                <a href="#" class="list-group-item">
                    {{ trans('application_settings.are_new_accounts_allowed') }}: <strong>@{{ allow_new_accounts }}</strong>
                    <span v-show="!allow_new_accounts_bool" v-on="click: allowNewAccounts()" class="underline pull-right">{{ trans('application_settings.allow_new_accounts') }}</span>
                    <span v-show="allow_new_accounts_bool" v-on="click: denyNewAccounts()" class="underline pull-right">{{ trans('application_settings.deny_new_accounts') }}</span>
                </a>
                <!-- END Allow new accounts -->

                <!-- BEGIN Allow users to change language -->
                <a href="#" class="list-group-item">
                    {{ trans('application_settings.are_users_allowed_to_change_language') }}: <strong>@{{ allow_users_to_change_language }}</strong>
                    <span v-show="!allow_users_to_change_language_bool" v-on="click: allowUsersToChangeLanguage()" class="underline pull-right">{{ trans('application_settings.allow_users_to_change_language') }}</span>
                    <span v-show="allow_users_to_change_language_bool" v-on="click: denyUsersToChangeLanguage()" class="underline pull-right">{{ trans('application_settings.deny_users_to_change_language') }}</span>
                </a>
                <!-- END Allow users to change language -->

            </ul>
        </div>
        <!-- END Security settings -->

    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/application-settings.js"></script>
@endsection