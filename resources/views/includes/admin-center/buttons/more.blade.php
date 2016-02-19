<!-- BEGIN Admin center menu -->
<div class="dropdown more-dropdown">

    <!-- BEGIN Menu -->
    <button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
        {{ trans('help_center.more') }}
        <span class="caret"></span>
    </button>
    <!-- END Menu -->

    <!-- BEGIN Menu items -->
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">

        <!-- BEGIN Users manager -->
        <li>
            <a href="/admin-center">
                <span class="glyphicon glyphicon-user icon-color"></span>&nbsp;
                {{ trans('users_manager.users_manager') }}
            </a>
        </li>
        <!-- END Users manager -->

        <div class="divider"></div>

        <!-- BEGIN Subscriptions -->
        <li>
            <a href="/admin-center/subscriptions">
                <span class="glyphicon glyphicon-calendar icon-color"></span>&nbsp;
                {{ trans('subscriptions.subscriptions') }}
            </a>
        </li>
        <!-- END Subscriptions -->

        <div class="divider"></div>

        <!-- BEGIN Products manager -->
        <li>
            <a href="/admin-center/products-manager">
                <span class="glyphicon glyphicon-list icon-color"></span>&nbsp;
                {{ trans('products_manager.products_manager') }}
            </a>
        </li>
        <!-- END Products manager -->

        <div class="divider"></div>

        <!-- BEGIN Logs viewer -->
        <li>
            <a href="/admin-center/logs">
                <span class="glyphicon glyphicon-pencil icon-color"></span>&nbsp;
                {{ trans('logs_viewer.logs_viewer') }}
            </a>
        </li>
        <!-- END Logs viewer -->

        <div class="divider"></div>

        <!-- BEGIN Application settings -->
        <li>
            <a href="/admin-center/application-settings">
                <span class="glyphicon glyphicon-cog icon-color"></span>&nbsp;
                {{ trans('application_settings.application_settings') }}
            </a>
        </li>
        <!-- END Application settings -->

        <div class="divider"></div>

        <!-- BEGIN Notifications -->
        <li>
            <a href="/admin-center/notifications">
                <span class="glyphicon glyphicon-bell icon-color"></span>&nbsp;
                {{ trans('notifications.notifications') }}
            </a>
        </li>
        <!-- END Notifications -->

        <div class="divider"></div>

        <!-- BEGIN Help center manager -->
        <li>
            <a href="/admin-center/help-center-manager">
                <span class="glyphicon glyphicon-question-sign icon-color"></span>&nbsp;
                {{ trans('help_center.help_center_manager') }}
            </a>
        </li>
        <!-- END Help center manager -->
    </ul>
    <!-- END Menu items -->

</div>
<!-- END Admin center menu -->