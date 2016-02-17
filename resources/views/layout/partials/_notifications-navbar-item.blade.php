<!-- BEGIN Notifications -->
<li id="notifications">
    <a v-on="click: markNotificationsAsRead" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
        <i class="glyphicon glyphicon-bell"></i>&nbsp;
        <strong v-show="!loading_notifications">+@{{ number_of_notifications }}</strong>
        <span v-show="loading_notifications" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
    </a>

    <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">

        <div class="notification-heading"><h4 class="menu-title">Notifications</h4><h4 class="menu-title pull-right">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
        </div>
        <li class="divider"></li>
        <div class="notifications-wrapper" v-repeat="notification in notifications">
            <a class="content" href="#">
                <div class="notification-item">
                    <h4 class="item-title">@{{ notification.title }}</h4>
                    <p class="item-info">@{{ notification.message }}</p>
                </div>

            </a>
        </div>
        <li class="divider"></li>
        <div class="notification-footer"><h4 class="menu-title"><a href="#">View all</a><i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div>
    </ul>
</li>
<!-- END Notifications -->