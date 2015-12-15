<!-- BEGIN Clients tab content -->
<div id="clients-tab" class="tab-pane fade">

    <!-- BEGIN Clients loader -->
    <div class="row text-center" v-show="loading_user_clients">
        <span class="glyphicon glyphicon-refresh glyphicon-spin tab-loader icon-color"></span>
    </div>
    <!-- END Clients loader -->

    <!-- BEGIN Clients of this user -->
    <div v-show="!loading_user_clients && clients.total > 0" class="dropdown">

        <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span id="user-email">{{ trans('users_manager.clients_of_this_user') }}</span><span class="caret"></span>
        </h5>

        <ul class="dropdown-menu">
            <!-- BEGIN Delete all user clients -->
            <li v-show="clients.total > 0">
                <a href="#" v-on="click: deleteAllUserClients()">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_clients') }}
                </a>
            </li>
            <!-- END Delete all user clients -->
        </ul>
    </div>
    <!-- END Clients of this user -->

    <!-- BEGIN User clients -->
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
                <td class="text-center danger-hover"><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- END User clients -->

    <div v-show="clients.total < 1 && !loading_user_clients" class="alert alert-danger alert-top">{{ trans('users_manager.user_has_no_clients') }}</div>

</div>
<!-- END Clients tab content -->