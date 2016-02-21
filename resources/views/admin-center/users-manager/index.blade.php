@extends('layout.index')
@section('content')
    @include('includes.ajax-translations.users-manager')
    <div id="users-manager">
        <div v-show="loaded">
            <!-- BEGIN Top part -->
            <div class="add-product-button row">
                <span class="admin-center-title">{{ trans('users_manager.users_manager') }}</span>&nbsp;

                @include('includes.admin-center.buttons.more-options-dropdown', [
                    'icon' => 'glyphicon-th-large',
                    'items' => [
                        [
                            'url' => '/admin-center/users_manager/browse',
                            'name' => trans('users_manager.browse'),
                            'icon' => 'glyphicon-list'
                        ],
                        [
                            'url' => '#',
                            'name' => trans('users_manager.create_new_user'),
                            'icon' => 'glyphicon-plus',
                            'data_target' => '#create-new-user-modal',
                            'data_toggle' => 'modal',
                            'on_click' => 'resetCreateNewUserModal'
                        ]
                    ]
                ])

                <div class="btn-group pull-right">
                    @include('includes.admin-center.buttons.more')
                </div>
            </div>
            <!-- END Top part -->

            <!-- BEGIN Search users -->
            <div class="well custom-well row">
                <div class="form-group has-feedback">
                    <label for="email">{{ trans('users_manager.search') }}:</label>
                    <input id="users-search" type="text" class="form-control" placeholder="{{ trans('users_manager.email') }}">
                    <i class="glyphicon glyphicon-envelope form-control-feedback email-icon icon-color"></i>
                    <i class="glyphicon glyphicon-refresh form-control-feedback search-user-loading-icon icon-color glyphicon-spin"></i>
                </div>
            </div>
            <!-- END Search users -->

            <!-- BEGIN Users statistics -->
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item active"><span class="glyphicon glyphicon-stats"></span> {{ trans('users_manager.users_statistics') }}</li>

                    <li class="list-group-item"><span class="badge">@{{ registered_users }}</span> {{ trans('users_manager.registered_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ confirmed_users }}</span> {{ trans('users_manager.confirmed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ not_confirmed_users }}</span> {{ trans('users_manager.not_confirmed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users_manager.subscribed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users_manager.not_subscribed_users') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users_manager.users_registered_today') }}</li>
                </ul>
            </div>
            <!-- END Users statistics -->

            <!-- BEGIN Users statistics in percentages -->
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item active"><span class="glyphicon glyphicon-stats"></span> {{ trans('users_manager.users_statistics_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ confirmed_users_percentage }}%</span> {{ trans('users_manager.confirmed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ not_confirmed_users_percentage }}%</span> {{ trans('users_manager.not_confirmed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }}%</span> {{ trans('users_manager.subscribed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ statistics.total_discount }} ron</span> {{ trans('users_manager.not_subscribed_users_percentage') }}</li>
                    <li class="list-group-item"><span class="badge">@{{ users_registered_today_percentage }}%</span> {{ trans('users_manager.users_registered_today_percentage') }}</li>
                </ul>
            </div>
            <!-- END Users statistics in percentages -->
        </div>

        @include('includes.modals.users-manager.create-new-user')

    </div>
@endsection

@section('scripts')
    <script src="/js/users-manager.js"></script>
@endsection