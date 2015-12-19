<!-- BEGIN Actions tab content -->
<div id="actions-tab" class="tab-pane fade">

    <!-- BEGIN User actions loader -->
    <div class="row text-center" v-show="loading_user_actions">
        <span class="glyphicon glyphicon-refresh glyphicon-spin tab-loader icon-color"></span>
    </div>
    <!-- END User actions loader -->

    <!-- BEGIN Actions of this user -->
    <div v-show="!loading_user_actions" class="dropdown">

        <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span id="user-email">{{ trans('users_manager.actions_of_this_user') }}</span>
            <span class="caret"></span>
        </h5>

        <ul class="dropdown-menu">

            <!-- BEGIN View all user actions -->
            <li v-on="click:getAllUserActions">
                <a href="#">
                    <span class="glyphicon glyphicon-asterisk">&nbsp;</span> {{ trans('users_manager.view_all_actions') }}
                </a>
            </li>
            <!-- END View all user actions -->

            <!-- BEGIN Delete all user actions -->
            <li>
                <a href="#" v-on="click: deleteUserActions">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_actions') }}
                </a>
            </li>
            <!-- END Delete all user actions -->

            <li class="divider"></li>

            <!-- BEGIN View only allowed user actions -->
            <li v-on="click:getOnlyAllowedActions">
                <a href="#">
                    <span class="glyphicon glyphicon-ok-circle">&nbsp;</span> {{ trans('users_manager.view_only_allowed_actions') }}
                </a>
            </li>
            <!-- END View only allowed user actions -->

            <!-- BEGIN Delete allowed user actions -->
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_allowed_user_actions') }}
                </a>
            </li>
            <!-- END Delete allowed user actions -->

            <li class="divider"></li>

            <!-- BEGIN View only info user actions -->
            <li v-on="click:getOnlyInfoActions">
                <a href="#">
                    <span class="glyphicon glyphicon-info-sign">&nbsp;</span> {{ trans('users_manager.view_only_info_actions') }}
                </a>
            </li>
            <!-- END View only info user actions -->

            <!-- BEGIN Delete info user actions -->
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_info_user_actions') }}
                </a>
            </li>
            <!-- END Delete info user actions -->

            <li class="divider"></li>

            <!-- BEGIN View only wrong format user actions -->
            <li  v-on="click:getOnlyWrongFormatActions">
                <a href="#">
                    <span class="glyphicon glyphicon-exclamation-sign">&nbsp;</span> {{ trans('users_manager.view_only_wrong_format_actions') }}
                </a>
            </li>
            <!-- END View only wrong format user actions -->

            <!-- BEGIN Delete wrong format user actions -->
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_wrong_format_user_actions') }}
                </a>
            </li>
            <!-- END Delete wrong format user actions -->

            <li class="divider"></li>

            <!-- BEGIN View only not allowed actions -->
            <li v-on="click:getOnlyNotAllowedActions">
                <a href="#">
                    <span class="glyphicon glyphicon-remove-circle">&nbsp;</span> {{ trans('users_manager.view_only_not_allowed_actions') }}
                </a>
            </li>
            <!-- END View only not allowed actions -->

            <!-- BEGIN Delete not allowed user actions -->
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_not_allowed_user_actions') }}
                </a>
            </li>
            <!-- END Delete not allowed user actions -->

        </ul>
    </div>
    <!-- END Actions of this user -->

    <!-- BEGIN User actions -->
    <div class="panel panel-default" v-show="!loading_user_actions && actions.total > 0">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">{{ trans('users_manager.action_id') }}</th>
                <th class="text-center">{{ trans('users_manager.action_type') }}</th>
                <th class="text-center">{{ trans('users_manager.action_message') }}</th>
                <th class="text-center">{{ trans('users_manager.created_at') }}</th>
                <th class="text-center">{{ trans('users_manager.delete_action') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-repeat="action in actions.data">
                <td class="text-center">#@{{ action.id }}</td>
                <td class="text-center" v-class="
                    text-success : action.type=='allowed',
                    text-primary : action.type=='info',
                    text-warning : action.type=='wrong_format',
                    text-danger : action.type=='not_allowed'
                "><b>@{{ action.name }}</b></td>
                <td class="text-center">@{{ action.message }}</td>
                <td class="text-center">@{{ action.created_at }}</td>
                <td v-on="click:deleteUserAction(action.id)" class="text-center danger-hover"><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- END User actions -->

    <!-- BEGIN Pagination links -->
    <ul class="pager" v-show="actions.total > actions.per_page && !loading_user_actions">
        <li v-class="disabled : !actions.prev_page_url"><a href="#" v-on="click: getUserActions(actions.prev_page_url)">{{ trans('common.previous') }}</a></li>
        <li v-class="disabled : !actions.next_page_url"><a href="#" v-on="click: getUserActions(actions.next_page_url)">{{ trans('common.next') }}</a></li>
    </ul>
    <!-- END Pagination links -->

    <div v-show="actions.total < 1 && !loading_user_actions" class="alert alert-danger alert-top">{{ trans('users_manager.user_has_no_actions') }}</div>

</div>
<!-- END Actions tab content  -->