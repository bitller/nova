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
    <div class="panel panel-default" v-show="!loading_user_clients && clients.total > 0">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">{{ trans('users_manager.client_name') }}</th>
                <th class="text-center">{{ trans('users_manager.phone_number') }}</th>
                <th class="text-center">{{ trans('users_manager.number_of_orders') }}</th>
                <th class="text-center">{{ trans('users_manager.client_since') }}</th>
                <th class="text-center">{{ trans('users_manager.delete_client') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-repeat="client in clients.data">
                <td class="text-center">@{{ client.name }}</td>
                <td class="text-center">
                    <span v-show="client.phone_number">@{{ client.phone_number }}</span>
                    <span v-show="!client.phone_number">{{ trans('users_manager.not_added') }}</span>
                </td>
                <td class="text-center">@{{ client.orders }}</td>
                <td class="text-center">@{{ client.created_at }}</td>
                <td v-on="click:deleteUserClient(client.id)" class="text-center danger-hover"><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- END User actions -->

    <div v-show="actions.total < 1 && !loading_user_actions" class="alert alert-danger alert-top">{{ trans('users_manager.user_has_no_actions') }}</div>

</div>
<!-- END Actions tab content  -->