<!-- BEGIN Waiting subscriptions tab content -->
<div id="waiting-subscriptions-tab" class="tab-pane fade in active">

    @include('admin-center.subscriptions.partials.loader', ['loadedTab' => 'waiting'])

    <!-- BEGIN Waiting subscriptions options -->
    <div v-show="!loading_waiting_subscriptions && waiting_subscriptions.total > 0" class="dropdown">

        @include('admin-center.subscriptions.partials.options', ['text' => trans('subscriptions.options')])

        <ul class="dropdown-menu">
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-adjust">&nbsp;</span> options
                </a>
            </li>
        </ul>
    </div>
    <!-- END Waiting subscriptions options -->

    <!-- BEGIN Active subscriptions -->
    <div class="panel panel-default" v-show="!loading_waiting_subscriptions && waiting_subscriptions.total > 0">
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
            <tr v-repeat="waiting_subscription in waiting_subscriptions.data">
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

    <div v-show="waiting_subscriptions.total < 1 && !loading_waiting_subscriptions" class="alert alert-danger alert-top">{{ trans('subscriptions.no_active_subscriptions') }}</div>

</div>
<!-- END Waiting subscriptions tab content -->