@extends('layout.index')

@section('fonts')
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
@endsection

@section('full-width')
    <div class="jumbotron custom-jumbotron">

        <div class="container">
            <div class="col-md-12 text-center page-text-container">
                <span class="page-text">{{ trans('help_center.help_center') }}</span>
            </div>

            <div class="col-md-8 col-md-offset-2 text-center page-description-container">
                <span class="page-description">{{ trans('help_center.description') }}</span>
            </div>
        </div>
    </div>
    @endsection
    @section('content')
        <div id="help-center">
            @include('includes.ajax-translations.common')

            <div class="alert alert-danger" v-show="error">@{{ error }}</div>

            <!-- END Recommended resources -->
            <div v-repeat="category in categories" v-show="loaded">
                <div class="fancy-divider col-md-12" v-show="category.number_of_articles">
                    <span>@{{ category.name }}</span>
                </div>
                <div class="col-md-6" v-repeat="article in category.articles" v-show="category.number_of_articles">
                    <div class="well custom-well">
                        <div><b>@{{ article.title }}</b></div>
                        <span class="well-text">@{{ article.content }}</span>
                    </div>
                </div>
            </div>
            
            <div v-show="!loaded" class="col-md-12 text-center">
                <span class="glyphicon glyphicon-refresh glyphicon-spin help-center-load-icon"></span>
            </div>

            @include('includes.modals.ask-question')

        </div>
    @endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/help-center.js"></script>
@endsection