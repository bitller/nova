<!-- BEGIN Notifications -->
<li id="notifications">
    <a v-on="click: markNotificationsAsRead" id="dLabel" role="button" data-toggle="dropdown" data-target="#">
        <i class="glyphicon glyphicon-bell"></i>&nbsp;
        <span>{{ trans('notifications.notifications') }}</span>
        <span v-show="!loading_notifications">(<strong>@{{ number_of_notifications_counter }}</strong>)</span>
        <span v-show="loading_notifications" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
    </a>

    <!-- BEGIN Notifications drop down -->
    <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">

        <!-- BEGIN Notifications text -->
        <div class="notification-heading">
            <h4 class="menu-title">
                <span class="glyphicon glyphicon-bell"></span>&nbsp;
                {{ trans('notifications.notifications') }}
            </h4>
        </div>
        <!-- END Notifications text -->

        <li class="divider"></li>

        <div class="notifications-wrapper" v-repeat="notification in notifications">
            <!-- BEGIN Notification -->
            <a class="content" href="#">
                <div class="notification-item">
                    <h4 class="item-title">@{{ notification.title }}</h4>
                    <p class="item-info">@{{ notification.message }}</p>
                </div>
            </a>
            <!-- END Notification -->
        </div>

        {{--<!-- BEGIN No notifications -->--}}
        <div class="no-notifications" v-show="number_of_notifications < 1">
            <span>{{ trans('notifications.no_notifications') }}</span>
        </div>
        {{--<!-- END No notifications -->--}}

    </ul>
    <!-- END Notifications drop down -->

</li>
<!-- END Notifications -->