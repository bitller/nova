<!-- BEGIN Bills tab content -->
<div id="bills-tab" class="tab-pane fade in active">

    <div class="row text-center" v-show="loading_user_bills">
        <span class="glyphicon glyphicon-refresh glyphicon-spin tab-loader icon-color"></span>
    </div>

    <div v-show="!loading_user_bills" class="dropdown">
        <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="user-email">{{ trans('users_manager.bills_of_this_user') }}</span><span class="caret"></span></h5>
        <ul class="dropdown-menu">
            <!-- BEGIN Delete all user bills -->
            <li v-show="bills.total > 0">
                <a href="#" v-on="click: deleteAllUserBills()">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_bills') }}
                </a>
            </li>
            <!-- END Delete all user bills -->

            <!-- BEGIN Delete all unpaid user bills -->
            <li v-show="bills.total > 0">
                <a href="#" v-on="click: deleteAllUserBills(true)">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_unpaid_bills') }}
                </a>
            </li>
            <!-- END Delete all unpaid user bills -->

            <li class="divider"></li>

            <!-- BEGIN Make all user bills paid -->
            <li v-show="bills.total > 0">
                <a href="#" v-on="click: changeUserBillsPaidStatus()">
                    <span class="glyphicon glyphicon-ok">&nbsp;</span> {{ trans('users_manager.mark_all_bills_as_paid') }}
                </a>
            </li>
            <!-- END Make all user bills paid -->
        </ul>
    </div>

    <!-- BEGIN User bills -->
    <div class="panel panel-default" v-show="!loading_user_bills && bills.total > 0">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">{{ trans('users_manager.client') }}</th>
                <th class="text-center">{{ trans('users_manager.order') }}</th>
                <th class="text-center">{{ trans('users_manager.campaign') }}</th>
                <th class="text-center">{{ trans('users_manager.price') }}</th>
                <th class="text-center">{{ trans('users_manager.created_at') }}</th>
                <th class="text-center">{{ trans('users_manager.payment_term')}}</th>
                <th class="text-center">{{ trans('users_manager.mark_as_paid') }}</th>
                <th class="text-center">{{ trans('users_manager.delete_bill') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-repeat="bill in bills.data">
                <td class="text-center">@{{ bill.client_name }}</td>
                <td class="text-center">@{{ bill.campaign_order }}</td>
                <td class="text-center">@{{ bill.campaign_number }}</td>
                <td class="text-center">@{{ bill.price }}</td>
                <td class="text-center">@{{ bill.created_at }}</td>
                <td class="text-center">
                    <span v-show="bill.payment_term != '0000-00-00' && bill.payment_term">@{{ bill.payment_term }}</span>
                    <span v-show="bill.payment_term == '0000-00-00' || !bill.payment_term">{{ trans('users_manager.payment_term_not_set') }}</span>
                </td>
                <td v-on="click:makeUserBillPaid(bill.id)" class="text-center primary-hover"><span class="glyphicon glyphicon-ok icon-color"></span></td>
                <td v-on="click:deleteUserBill(bill.id)" class="text-center danger-hover"><span class="glyphicon glyphicon-trash icon-color"></span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- END User bills -->

    <div v-show="bills.total < 1" class="alert alert-danger">{{ trans('users_manager.user_has_no_bills') }}</div>

</div>
<!-- END Bills tab content -->