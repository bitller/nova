<!-- BEGIN Email dropdown -->
<ul class="nav navbar-nav navbar-right">
    <li>
        <!-- BEGIN Email -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span id="user-email">
                {{ Auth::user()->email }}
            </span>
            <span class="caret"></span>
        </a>
        <!-- END Email -->

        <!-- BEGIN Dropdown -->
        <ul class="dropdown-menu">
            @if ($showAdminCenter)

                <!-- BEGIN Admin center option -->
                <li>
                    <a href="/admin-center">
                        <span class="glyphicon glyphicon-wrench icon-color">&nbsp;</span>
                        {{ trans('header.admin_center') }}
                    </a>
                </li>
                <!-- END Admin center option -->
                <li role="separator" class="divider"></li>
            @endif

            <!-- BEGIN Settings option -->
            <li>
                <a href="/settings">
                    <span class="glyphicon glyphicon-cog icon-color">&nbsp;</span>
                    {{ trans('header.settings') }}
                </a>
            </li>
            <!-- END Settings option -->

            <li><a href="/statistics"><span class="glyphicon glyphicon-stats icon-color">&nbsp;</span>{{ trans('header.statistics') }}</a></li>
            <li><a href="/about"><span class="glyphicon glyphicon-info-sign icon-color">&nbsp;</span>{{ trans('header.about') }}</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/logout"><span class="glyphicon glyphicon-off icon-color">&nbsp;</span>{{ trans('header.logout') }}</a></li>
        </ul>
        <!-- END Dropdown -->
    </li>
</ul>
<!-- END Email dropdown -->