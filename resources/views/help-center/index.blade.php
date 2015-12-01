@extends('layout')
@section('full-width')
    <div class="jumbotron custom-jumbotron">

        <div class="container">
            <h2 class="text-center page-text">{{ trans('help_center.help_center') }}</h2>

            {{--<div class="form-group col-md-8 col-md-offset-2 search-field">--}}
                {{--<input class="form-control input-lg" placeholder="{{ trans('help_center.how_can_we_help') }}">--}}
            {{--</div>--}}
            <div class="col-md-8 col-md-offset-2 text-center page-description">
                <h4>{{ trans('help_center.description') }}</h4>
            </div>
            <div class="col-md-12 text-center ask-button">
                <a href="#"><button class="btn btn-lg btn-danger">{{ trans('help_center.contact_us') }}</button></a>
            </div>
        </div>
    </div>
    @endsection
    @section('content')
        <div id="help-center" v-show="loaded">
            @include('includes.ajax-translations.common')

            <!-- END Recommended resources -->
            <div v-repeat="category in categories">
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

            @include('includes.modals.ask-question')

        </div>
    @endsection

@section('scripts')
    <script src="/js/help-center.js"></script>
@endsection