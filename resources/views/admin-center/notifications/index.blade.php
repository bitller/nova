@extends('layout.index')
@section('content')

<div id="notifications-manager">

    @include('includes.ajax-translations.common')

    <div v-show="!loading">
        <!-- BEGIN Top part -->
        <div class="add-product-button">
            <span class="admin-center-title">
                {{ trans('notifications.notifications_manager') }}
            </span>&nbsp;

            @include('includes.admin-center.buttons.more-options-dropdown', [
                'icon' => 'glyphicon-th-large',
                    'items' => [
                        [
                            'url' => '#',
                            'name' => trans('notifications.create_new_notification'),
                            'icon' => 'glyphicon-plus',
                            'data_target' => '#create-new-notification-modal',
                            'data_toggle' => 'modal',
                            'on_click' => 'getTypes()'
                        ]
                    ]
            ])

            <div class="btn-group pull-right">
                @include('includes.admin-center.buttons.more')
            </div>
        </div>
        <!-- END Top part -->

        <!-- BEGIN Notifications table-->
        <div class="panel panel-default" v-show="number_of_notifications > 0">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <!-- BEGIN Type -->
                        <th class="text-center">
                            <span>
                                <span class="glyphicon glyphicon-tag icon-color"></span>&nbsp;
                                {{ trans('notifications.type') }}
                            </span>
                        </th>
                        <!-- END Type -->

                        <!-- BEGIN Title -->
                        <th class="text-center">
                            <span>
                                <span class="glyphicon glyphicon-bell icon-color"></span>&nbsp;
                                {{ trans('notifications.title') }}
                            </span>
                        </th>
                        <!-- END Title -->

                        <!-- BEGIN Message -->
                        <th class="text-center">
                            <span>
                            <span class="glyphicon glyphicon-bullhorn icon-color"></span>&nbsp;
                                {{ trans('notifications.message') }}
                            </span>
                        </th>
                        <!-- END Message -->

                        <!-- BEGIN Created at -->
                        <th class="text-center">
                            <span>
                                <span class="glyphicon glyphicon-calendar icon-color"></span>&nbsp;
                                {{ trans('notifications.created_at') }}
                            </span>
                        </th>
                        <!-- END Created at -->

                        <!-- BEGIN Delete -->
                        <th class="text-center">
                            <span>
                                <span class="glyphicon glyphicon-trash icon-color"></span>&nbsp;
                                {{ trans('notifications.delete') }}
                            </span>
                        </th>
                        <!-- END Delete -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-repeat="notification in notifications">

                        <!-- BEGIN Type -->
                        <td class="text-center vert-align">
                            <span>@{{ notification.type }}</span>
                        </td>
                        <!-- END Type -->

                        <!-- BEGIN Title -->
                        <td v-on="click:setCurrentTitle(notification.title, notification.id)" class="text-center vert-align" data-toggle="modal" data-target="#edit-notification-title-modal">
                            <span>@{{ notification.title }}</span>
                        </td>
                        <!-- END Title -->

                        <!-- BEGIN Message -->
                        <td class="text-center vert-align">
                            <span>@{{ notification.message }}</span>
                        </td>
                        <!-- END Message -->

                        <!-- BEGIN Created at -->
                        <td class="text-center vert-align">
                            <span>@{{ notification.created_at }}</span>
                        </td>
                        <!-- END Created at -->

                        <!-- BEGIN Delete -->
                        <td class="text-center vert-align">
                            <button v-on="click: deleteNotification(notification.id)" class="btn btn-default">
                                <span class="glyphicon glyphicon-trash"></span>&nbsp;
                                {{ trans('common.delete') }}
                            </button>
                        </td>
                        <!-- END Delete -->
                    </tr>
                </tbody>
            </table>
        </div>

        <button class="btn btn-default btn-block" v-on="click:viewAllNotifications()" v-attr="disabled:show_all_notifications_button_loader">
            <span v-show="!all_notifications_are_displayed && !show_all_notifications_button_loader">{{ trans('notifications.show_all_notifications') }}</span>
            <span v-show="all_notifications_are_displayed && !show_all_notifications_button_loader">{{ trans('notifications.hide_all_notifications') }}</span>
            <span v-show="show_all_notifications_button_loader" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
        </button>

        @include('includes.modals.notifications.create-notification-modal')
        @include('includes.modals.notifications.edit-notification-title-modal')

    </div>
    <!-- END Notifications table -->
</div>
@endsection

@section('scripts')
<script src="/js/notifications-manager.js"></script>
@endsection