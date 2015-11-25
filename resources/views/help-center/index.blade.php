@extends('layout')
    @section('content')
        <div id="help-center" v-show="loaded">
            @include('includes.ajax-translations.common')

            <!-- BEGIN Help center jumbotron -->
        <div class="row jumbotron custom-jumbotron">

            <div class="container">
                <h2 class="text-center text-primary page-text">Help center</h2>

                <div class="form-group col-md-8 col-md-offset-2 search-field">
                    <input class="form-control" placeholder="How can we help?">
                </div>
                <div class="col-md-12 text-center">
                    <h4>or</h4>
                </div>
                <div class="col-md-12 text-center ask-button">
                    <button class="btn btn-lg btn-danger">Ask a question</button>
                </div>

            </div>
        </div>
        <!-- END Help center jumbotron -->

        <div class="list-group col-md-4" v-repeat="category in categories">
            <a href="#" class="list-group-item active">Getting started</a>
            <a href="#" class="list-group-item" v-repeat="article in category.articles">@{{ article.title }}</a>
            <h5 class="text-center"><a href="/help-center/category/@{{ category.id }}">View all articles</a></h5>
        </div>
        </div>
    @endsection

@section('scripts')
    <script src="/js/help-center.js"></script>
@endsection