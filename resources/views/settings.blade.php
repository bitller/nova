@extends('layout')
@section('content')
    @include('includes.ajax-translations.common')
    @include('includes.ajax-translations.settings')
    <div id="settings" v-show="loaded">

        <!-- BEGIN Reset to defaults button -->
        <div class="print-statistics-button">
            <span class="avon-products">{{ trans('settings.settings') }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('statistics.description') }}">?</span></span>
            <a href="/my-products"><button type="button" class="btn btn-primary pull-right" v-on="click: addClient()">
                    <span class="glyphicon glyphicon-print"></span> {{ trans('statistics.print') }}
                </button></a>
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
            <a href="#" class="list-group-item">
                {{ trans('settings.password') }}: <strong>*********</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END User password -->

            <!-- BEGIN Number of displayed bills -->
            <a href="#" class="list-group-item">
                {{ trans('settings.number_of_displayed_bills') }}: <strong>@{{ displayed_bills }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of displayed bills -->

            <!-- BEGIN Number of displayed clients -->
            <a href="#" class="list-group-item">
                {{ trans('settings.number_of_displayed_clients') }}: <strong>@{{ displayed_clients }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of displayed clients -->

            <!-- BEGIN Number of displayed products -->
            <a href="#" class="list-group-item">
                {{ trans('settings.number_of_displayed_products') }}: <strong>@{{ displayed_products }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of displayed products -->

            <!-- BEGIN Number of user products displayed -->
            <a href="#" class="list-group-item">
                {{ trans('settings.number_of_your_products_displayed') }}: <strong>@{{ displayed_custom_products }}</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
            <!-- END Number of user products displayed -->

            <a href="#" class="list-group-item">
                {{ trans('settings.language') }}: <strong>Romana</strong>
                <div class="pull-right">
                    <span class="glyphicon glyphicon-pencil"></span>
                </div>
            </a>
        </ul>
        <!-- END Settings list -->
    </div>
@endsection

@section('scripts')
    <script src="/js/settings.js"></script>
@endsection