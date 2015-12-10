@extends('layout')
@section('content')
    @include('includes.ajax-translations.help-center-manager')
    <div id="help-center-manager-category-page" v-show="loaded" category-id="{{ $categoryId }}">

        <!-- BEGIN Top part -->
        <div class="add-product-button">
            <span class="avon-products">@{{ category.name }}</span>&nbsp;

            <button class="btn btn-danger" data-toggle="modal" data-target="#add-article-modal" v-on="click: resetAddArticleModal()"><span class="glyphicon glyphicon-plus"></span></button>

            <div class="btn-group pull-right">
                @include('includes.admin-center.buttons.subscriptions')
                @include('includes.admin-center.buttons.products-manager')
                @include('includes.admin-center.buttons.logs')
                @include('includes.admin-center.buttons.application-settings')
                @include('includes.admin-center.buttons.more')
            </div>
        </div>
        <!-- END Top part -->

        <div class="alert alert-warning" v-show="!articles">{{ trans('help_center.no_articles') }}</div>

        <div class="panel panel-default" v-show="articles">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{ trans('help_center.article_title') }}</th>
                    <th>{{ trans('help_center.edit') }}</th>
                    <th>{{ trans('help_center.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-repeat="article in articles">
                    <td>@{{ article.title }}</td>
                    <td v-on="click: setClickedArticle(article.id, article.title, article.content)" class="text-center" data-toggle="modal" data-target="#edit-article-modal"><span class="glyphicon glyphicon-pencil"></span></td>
                    <td v-on="click: deleteArticle(article.id)" class="text-center"><span class="glyphicon glyphicon-trash"></span></td>
                </tr>
                </tbody>
            </table>
        </div>

        @include('includes.modals.add-article-modal')
        @include('includes.modals.edit-article')

    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/help-center-manager-category-page.js"></script>
@endsection