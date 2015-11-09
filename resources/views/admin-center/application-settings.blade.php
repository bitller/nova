@extends('layout')
@section('content')
    <div id="application-settings" v-show="loaded">

        <!-- BEGIN Top part -->
        <div class="add-product-button row">

            <span class="avon-products">{{ trans('application_settings.application_settings') }}</span>&nbsp;

            <div class="btn-group pull-right">
                @include('includes.admin-center.buttons.users-manager')
                @include('includes.admin-center.buttons.subscriptions')
                @include('includes.admin-center.buttons.products-manager')
                @include('includes.admin-center.buttons.logs')
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
                <a href="#" class="list-group-item">
                    {{ trans('application_settings.bills_displayed') }}: <strong>10</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of bills displayed -->

                <!-- BEGIN Number of paid bills displayed -->
                <a href="#" class="list-group-item">
                    {{ trans('application_settings.paid_bills_displayed') }}: <strong>10</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of paid bills displayed -->

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
                <a href="#" class="list-group-item">
                    {{ trans('application_settings.clients_displayed') }}: <strong>10</strong>
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
                <a href="#" class="list-group-item">
                    {{ trans('application_settings.products_displayed') }}: <strong>10</strong>
                    @include('includes.common.edit-icon')
                </a>
                <!-- END Number of products displayed -->

                <!-- BEGIN Number of application products displayed -->
                <a href="#" class="list-group-item">
                    {{ trans('application_settings.custom_products_displayed') }}: <strong>10</strong>
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

            </ul>
        </div>
        <!-- END Security settings -->

    </div>
@endsection

@section('scripts')
@endsection