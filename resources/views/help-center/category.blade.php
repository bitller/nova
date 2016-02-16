@extends('layout.index')
@section('content')

    <div id="help-center-category" v-show="loaded" category-id="{{ $categoryId }}">

        @include('includes.ajax-translations.help-center-manager')

        <!-- BEGIN Top part -->
        <div class="add-product-button">
            <span class="avon-products">{{ trans('help_center.help_center') }} - @{{ category.name }} <span class="badge">@{{ products.total }}</span></span>
            <a href="/help-center">
                <button type="button" class="btn btn-primary pull-right">
                    <span class="glyphicon glyphicon-arrow-left"></span> {{ trans('help_center.back_to_help_center') }}
                </button>
            </a>
        </div>
        <!-- END Top part -->

        <div class="panel-group" id="accordion">

            <div class="panel panel-default" v-repeat="article in category.articles" id="article-@{{ article.id }}">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-target="#@{{ article.id }}" href="#@{{ article.id }}" class="collapsed">
                            @{{ article.title }}
                        </a>
                    </h4>

                </div>
                <div id="@{{ article.id }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        @{{ article.content }}
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('scripts')
    <script src="/js/help-center-category.js"></script>
@endsection