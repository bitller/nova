@extends('layout.index')
@section('content')

    @include('includes.ajax-translations.help-center-manager')

    <div id="help-center-manager" v-show="loaded">

        <!-- BEGIN Top part -->
        <div class="add-product-button">
            <span class="admin-center-title">{{ trans('help_center.help_center_manager') }}</span>&nbsp;
            <button class="btn btn-default" v-on="click: addCategory()"><span class="glyphicon glyphicon-plus"></span></button>
            <div class="btn-group pull-right">
                @include('includes.admin-center.buttons.more')
            </div>
        </div>
        <!-- END Top part -->

        <div class="alert alert-warning" v-show="!show_categories">{{ trans('help_center.no_category') }}</div>

        <!-- BEGIN Categories table -->
        <div class="panel panel-default" v-show="show_categories">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{ trans('help_center.category_name') }}</th>
                    <th>{{ trans('help_center.number_of_articles') }}</th>
                    <th>{{ trans('help_center.edit') }}</th>
                    <th>{{ trans('help_center.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-repeat="category in categories">
                    <td><a href="/admin-center/help-center-manager/category/@{{ category.id }}">@{{ category.name }}</a></td>
                    <td class="text-center">@{{ category.number_of_articles }}</td>
                    <td v-on="click: editCategory(category.id)" class="text-center pointer"><span class="glyphicon glyphicon-pencil"></span></td>
                    <td v-on="click: deleteCategory(category.id)" class="text-center pointer"><span class="glyphicon glyphicon-trash"></span></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- END Categories table -->

    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/help-center-manager.js"></script>
@endsection