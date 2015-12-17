<!-- BEGIN Actions tab content -->
<div id="actions-tab" class="tab-pane fade">

    <!-- BEGIN User actions loader -->
    <div class="row text-center" v-show="loading_user_actions">
        <span class="glyphicon glyphicon-refresh glyphicon-spin tab-loader icon-color"></span>
    </div>
    <!-- END User actions loader -->

    <!-- BEGIN Actions of this user -->
    <div v-show="!loading_user_actions && actions.total > 0" class="dropdown">

        <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span id="user-email">{{ trans('users_manager.actions_of_this_user') }}</span>
            <span v-show="actions.total > 0" class="caret"></span>
        </h5>

        <ul v-show="actions.total > 0" class="dropdown-menu">
            <!-- BEGIN Delete all user actions -->
            <li>
                <a href="#" v-on="click: deleteUserActions">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_actions') }}
                </a>
            </li>
            <!-- END Delete all user actions -->

            <!-- BEGIN Delete allowed user actions -->
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_allowed_user_actions') }}
                </a>
            </li>
            <!-- END Delete allowed user actions -->

            <!-- BEGIN Delete info user actions -->
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_info_user_actions') }}
                </a>
            </li>
            <!-- END Delete info user actions -->

            <!-- BEGIN Delete wrong format user actions -->
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_wrong_format_user_actions') }}
                </a>
            </li>
            <!-- END Delete wrong format user actions -->

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

    <div v-show="actions.total < 1 && !loading_user_actions" class="alert alert-danger alert-top">{{ trans('users_manager.user_has_no_actions') }}</div>

</div>
<!-- END Actions tab content  -->