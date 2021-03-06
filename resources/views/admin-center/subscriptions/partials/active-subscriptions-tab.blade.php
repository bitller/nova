<!-- BEGIN Active subscriptions tab content -->
<div id="active-subscriptions-tab" class="tab-pane fade in active">

    @include('admin-center.subscriptions.partials.loader', ['loadedTab' => 'active'])

    <!-- BEGIN Active subscriptions options -->
    <div v-show="!loading_active_subscriptions && active_subscriptions.total > 0" class="dropdown">

        <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span id="user-email">{{ trans('subscriptions.active_subscriptions') }}</span><span class="caret"></span>
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
    <!-- END Active subscriptions options -->

    <!-- BEGIN Active subscriptions -->
    <div class="panel panel-default" v-show="!loading_active_subscriptions && active_subscriptions.total > 0">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">{{ trans('subscriptions.user_email') }}</th>
                <th class="text-center">{{ trans('subscriptions.amount') }}</th>
                <th class="text-center">{{ trans('subscriptions.next_payment_term') }}</th>
                <th class="text-center">{{ trans('subscriptions.paid_until_now') }}</th>
                <th class="text-center">{{ trans('subscriptions.edit_subscription') }}</th>
                <th class="text-center">{{ trans('users_manager.disable_subscription') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-repeat="active_subscription in active_subscriptions.data">
                <td class="text-center">@{{ active_subscription.email }}</td>
                <td class="text-center">@{{ active_subscription.amount }}</td>
                <td class="text-center">@{{ client.orders }}</td>
                <td class="text-center">@{{ client.created_at }}</td>
                <td class="text-center">@{{ client.created_at }}</td>
                <td v-on="click:deleteUserClient(client.id)" class="text-center danger-hover"><span class="glyphicon ban-circle"></span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- END Active subscriptions -->

    <div v-show="active_subscriptions.total < 1 && !loading_active_subscriptions" class="alert alert-danger alert-top">{{ trans('subscriptions.no_active_subscriptions') }}</div>

</div>
<!-- END Clients tab content -->