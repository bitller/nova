@extends('layout')
@section('content')
    <div id="users-manager">
        <div v-show="loaded">
            <!-- BEGIN Top part -->
            <div class="add-product-button row">
                <span class="avon-products">{{ trans('users-manager.users_manager') }}</span>&nbsp;

                <!-- BEGIN Edit button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-th-large"></span>&nbsp;
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">

                        <!-- BEGIN Browse users -->
                        <li>
                            <a href="/admin-center/users-manager/browse">
                                <span class="glyphicon glyphicon-list"></span>&nbsp; {{ trans('users-manager.browse') }}
                            </a>
                        </li>
                        <!-- END Browser users -->

                    </ul>
                </div>
                <!-- END Edit button -->

                <div class="btn-group pull-right" v-show="!product.is_application_product">
                    @include('includes.admin-center.buttons.subscriptions')
                    @include('includes.admin-center.buttons.products-manager')
                    @include('includes.admin-center.buttons.logs')
                    @include('includes.admin-center.buttons.application-settings')
                </div>
            </div>
            <!-- END Top part -->

            <!-- BEGIN Search users -->
            <div class="jumbotron row">
                <div class="form-group has-feedback">
                    <label for="email">{{ trans('users-manager.search') }}:</label>
                    <input id="email" type="text" class="form-control" placeholder="{{ trans('users-manager.email') }}">
                    <i class="glyphicon glyphicon-envelope form-control-feedback icon-color"></i>
                </div>
            </div>
            <!-- END Search users -->

            <!-- BEGIN Users statistics -->
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item active"><span class="glyphicon glyphicon-stats"></span> {{ trans('users-manager.users_statistics') }}</li>

                    <li class="list-group-item"><span class="badge">@{{ statistics.number_of_clients }}</span> {{ trans('users-manager.registered_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.number_of_custom_products }}</span> {{ trans('users-manager.confirmed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.number_of_bills }} ron</span> {{ trans('users-manager.not_confirmed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users-manager.subscribed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users-manager.not_subscribed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users-manager.users_registered_today') }}</li>
                </ul>
            </div>
            <!-- END Users statistics -->

            <!-- BEGIN Users statistics in percentages -->
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item active"><span class="glyphicon glyphicon-stats"></span> {{ trans('users-manager.users_statistics_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.number_of_products_sold }} ron</span> {{ trans('users-manager.confirmed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_price }} ron</span> {{ trans('users-manager.not_confirmed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users-manager.subscribed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users-manager.not_subscribed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users-manager.users_registered_today_percentage') }}</li>
                </ul>
            </div>
            <!-- END Users statistics in percentages -->

        </div>
    </div>
@endsection

@section('scripts')
@endsection