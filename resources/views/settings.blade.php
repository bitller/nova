@extends('layout.index')
@section('content')
    @include('includes.ajax-translations.common')
    @include('includes.ajax-translations.settings')
    <div id="settings" v-show="loaded">

        <!-- BEGIN Reset to defaults button -->
        <div class="print-statistics-button">
            <span class="avon-products">{{ trans('settings.settings') }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('settings.settings_tooltip') }}">?</span></span>
            <button type="button" class="btn btn-primary pull-right" v-on="click: resetToDefaultValues()">
                <span class="glyphicon glyphicon-print"></span> {{ trans('settings.reset_to_defaults') }}
            </button>
        </div>
        <!-- END Reset to defaults button -->

        <!-- BEGIN Settings list -->
        <ul class="list-group">

            <!-- BEGIN Settings title -->
            <li class="list-group-item active">
                <span class="glyphicon glyphicon-cog"></span>
                {{ trans('settings.general_settings') }}
            </li>
            <!-- END Settings title -->

            <!-- BEGIN User email -->
            <a href="#" class="list-group-item" v-on="click: editEmail()">
                {{ trans('settings.email') }}: <strong>@{{ email }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END User email -->

            <!-- BEGIN User password -->
            <a href="#" class="list-group-item" v-on="click: resetEditPasswordModal()" data-toggle="modal" data-target="#edit-password-modal">
                {{ trans('settings.password') }}: <strong>*********</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END User password -->

            <!-- BEGIN Number of displayed bills -->
            <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedBills()">
                {{ trans('settings.number_of_displayed_bills') }}: <strong>@{{ displayed_bills }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of displayed bills -->

            <!-- BEGIN Number of displayed clients -->
            <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedClients()">
                {{ trans('settings.number_of_displayed_clients') }}: <strong>@{{ displayed_clients }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of displayed clients -->

            <!-- BEGIN Number of displayed products -->
            <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedProducts()">
                {{ trans('settings.number_of_displayed_products') }}: <strong>@{{ displayed_products }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of displayed products -->

            <!-- BEGIN Number of user products displayed -->
            <a href="#" class="list-group-item" v-on="click: editNumberOfDisplayedCustomProducts()">
                {{ trans('settings.number_of_your_products_displayed') }}: <strong>@{{ displayed_custom_products }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of user products displayed -->

            @if ($allowUserToChangeLanguage)
            <!-- BEGIN Change language -->
            <a href="#" class="list-group-item" data-toggle="modal" data-target="#edit-language-modal" v-on="click: loadLanguages()">
                {{ trans('settings.language') }}: <strong>@{{ language_name }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Change language -->
            @endif
        </ul>
        <!-- END Settings list -->

        @include('includes.modals.edit-password')
        @include('includes.modals.edit-language')

    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/settings.js"></script>
@endsection