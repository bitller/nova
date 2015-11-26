@extends('layout')
    @section('content')
        <div id="help-center" v-show="loaded">
            @include('includes.ajax-translations.common')

            <!-- BEGIN Help center jumbotron -->
            <div class="jumbotron custom-jumbotron">

                <div class="container">
                    <h2 class="text-center page-text">{{ trans('help_center.help_center') }}</h2>

                    <div class="form-group col-md-8 col-md-offset-2 search-field">
                        <input class="form-control" placeholder="{{ trans('help_center.how_can_we_help') }}">
                    </div>
                    <div class="col-md-12 text-center">
                        <h4>{{ trans('common.or') }}</h4>
                    </div>
                    <div class="col-md-12 text-center ask-button">
                        <button class="btn btn-lg btn-danger" v-on="click: loadCategoriesAndResetModal()" data-toggle="modal" data-target="#ask-question-modal">{{ trans('help_center.ask_question') }}</button>
                    </div>
                    <div class="col-md-12 text-center ask-button">
                        <a href="#">See your questions</a>
                    </div>
                </div>
            </div>
            <!-- END Help center jumbotron -->

            {{--<div class="col-md-11 text-center">--}}
                {{--<a v-repeat="category in categories" href="/help-center/category/@{{ category.id }}">--}}
                    {{--<div class="well primary-well col-md-3 col-md-offset-1">@{{ category.name }}</div>--}}
                {{--</a>--}}
            {{--</div>--}}

            <!-- END Recommended resources -->
            <h3>Intrebarile tale</h3>
            <div class="panel panel-default">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Intrebarea</th>
                        <th>Raspunsuri</th>
                        <th>A primit raspuns corect</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="category in categories">
                        <td><a href="/help-center/category/@{{ category.id }}">@{{ category.name }}</a></td>
                        <td>4</td>
                        <td><span class="glyphicon glyphicon-ok"></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>


            @include('includes.modals.ask-question')

        </div>
    @endsection

@section('scripts')
    <script src="/js/help-center.js"></script>
@endsection