@extends('layout')
@section('content')
    <div id="settings">

        <!-- BEGIN Reset to defaults button -->
        <div class="print-statistics-button">
            <span class="avon-products">{{ trans('settings.settings') }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('statistics.description') }}">?</span></span>
            <a href="/my-products"><button type="button" class="btn btn-primary pull-right" v-on="click: addClient()">
                    <span class="glyphicon glyphicon-print"></span> {{ trans('statistics.print') }}
                </button></a>
        </div>
        <!-- END Reset to defaults button -->

        <ul class="list-group">
            <li class="list-group-item active"><span class="glyphicon glyphicon-cog"></span> {{ trans('settings.general_settings') }}</li>
            <li class="list-group-item"><strong>{{ trans('settings.email') }}:</strong> alexandru.bugarin@gmail.com <div class="pull-right"><span class="glyphicon glyphicon-pencil"></span><span> Edit</span></div></li>
            <li class="list-group-item"><strong>{{ trans('settings.password') }}:</strong> *********<div class="pull-right"><span class="glyphicon glyphicon-pencil"></span><span> Edit</span></div></li>
            <li class="list-group-item"><strong>{{ trans('settings.number_of_displayed_bills') }}:</strong> 10 <div class="pull-right"><span class="glyphicon glyphicon-pencil"></span><span> Edit</span></div></li>
            <li class="list-group-item"><strong>{{ trans('settings.number_of_displayed_clients') }}:</strong> 11<div class="pull-right"><span class="glyphicon glyphicon-pencil"></span><span> Edit</span></div></li>
            <li class="list-group-item"><strong>{{ trans('settings.number_of_displayed_products') }}:</strong> 10<div class="pull-right"><span class="glyphicon glyphicon-pencil"></span><span> Edit</span></div></li>
            <li class="list-group-item"><strong>{{ trans('settings.number_of_your_products_displayed') }}:</strong> 10<div class="pull-right"><span class="glyphicon glyphicon-pencil"></span><span> Edit</span></div></li>
            <li class="list-group-item"><strong>{{ trans('settings.language') }}:</strong> Romana<div class="pull-right"><span class="glyphicon glyphicon-pencil"></span><span> Edit</span></div></li>
        </ul>
    </div>
@endsection

@section('scripts')

@endsection