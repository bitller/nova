@extends('layout')
@section('content')
    @include('includes.ajax-translations.common')
    <div id="statistics" v-show="loaded">

        <!-- BEGIN Print statistics button -->
        <div class="print-statistics-button">
            <span class="avon-products">{{ trans('header.statistics') }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('statistics.description') }}">?</span></span>
            <a href="/my-products"><button type="button" class="btn btn-primary pull-right" v-on="click: addClient()">
                    <span class="glyphicon glyphicon-print"></span> {{ trans('statistics.print') }}
                </button></a>
        </div>
        <!-- END Print statistics button -->

        <ul class="list-group">
            <li class="list-group-item active"><span class="glyphicon glyphicon-stats"></span> {{ trans('statistics.general') }}</li>
            <li class="list-group-item"><span class="badge">@{{ statistics.number_of_clients }}</span> {{ trans('statistics.number_of_clients') }}</li>
            <li class="list-group-item"><span class="badge">@{{ statistics.number_of_custom_products }}</span> {{ trans('statistics.custom_products') }}</li>
            <li class="list-group-item"><span class="badge">@{{ statistics.number_of_products_sold }} ron</span> {{ trans('statistics.products_sold') }}</li>
            <li class="list-group-item"><span class="badge">@{{ statistics.number_of_bills }} ron</span> {{ trans('statistics.number_of_bills') }}</li>
            <li class="list-group-item"><span class="badge">@{{ statistics.total_price }} ron</span> {{ trans('statistics.total_price') }}</li>
            <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('statistics.total_discount') }}</li>
        </ul>
    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="js/statistics.js"></script>
@endsection