<!-- BEGIN Paid bills tab content -->
<div id="paid-bills-tab" class="tab-pane fade">

    <!-- BEGIN Paid bills loader -->
    <div class="row text-center" v-show="loading_user_paid_bills">
        <span class="glyphicon glyphicon-refresh glyphicon-spin tab-loader icon-color"></span>
    </div>
    <!-- END Paid bills loader -->

    <div v-show="!loading_user_paid_bills" class="dropdown">
        <h5 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="user-email">{{ trans('users_manager.paid_bills_of_this_user') }}</span><span class="caret"></span></h5>

        <ul class="dropdown-menu">
            <!-- BEGIN Delete all user bills -->
            <li v-show="paid_bills.total > 0">
                <a href="#" v-on="click: deleteAllUserBills()">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_bills') }}
                </a>
            </li>
            <!-- END Delete all user bills -->

            <!-- BEGIN Delete all paid user bills -->
            <li v-show="paid_bills.total > 0">
                <a href="#" v-on="click: deleteAllUserBills(false,true)">
                    <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_paid_bills') }}
                </a>
            </li>
            <!-- END Delete all paid user bills -->

            <li class="divider"></li>

            <!-- BEGIN Make all user bills unpaid -->
            <li v-show="paid_bills.total > 0">
                <a href="#" v-on="click: changeUserBillsPaidStatus(true)">
                    <span class="glyphicon glyphicon-remove">&nbsp;</span> {{ trans('users_manager.mark_all_bills_as_unpaid') }}
                </a>
            </li>
            <!-- END Make all user bills unpaid -->
        </ul>
    </div>

    <!-- BEGIN Paid bills -->
    <div class="panel panel-default" v-show="!loading_user_paid_bills && paid_bills.total > 0">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">{{ trans('users_manager.client') }}</th>
                <th class="text-center">{{ trans('users_manager.order') }}</th>
                <th class="text-center">{{ trans('users_manager.campaign') }}</th>
                <th class="text-center">{{ trans('users_manager.price') }}</th>
                <th class="text-center">{{ trans('users_manager.created_at') }}</th>
                <th class="text-center">{{ trans('users_manager.payment_term') }}</th>
                <th class="text-center">{{ trans('users_manager.mark_as_unpaid') }}</th>
                <th class="text-center">{{ trans('users_manager.delete_bill') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-repeat="paid_bill in paid_bills.data">
                <td class="text-center">@{{ paid_bill.client_name }}</td>
                <td class="text-center">@{{ paid_bill.campaign_order }}</td>
                <td class="text-center">@{{ paid_bill.campaign_number }}</td>
                <td class="text-center">@{{ paid_bill.price }}</td>
                <td class="text-center">@{{ paid_bill.created_at }}</td>
                <td class="text-center">
                    <span v-show="paid_bill.payment_term != '0000-00-00' && paid_bill.payment_term">@{{ paid_bill.payment_term }}</span>
                    <span v-show="paid_bill.payment_term == '0000-00-00' || !paid_bill.payment_term">{{ trans('users_manager.payment_term_not_set') }}</span>
                </td>
                <td v-on="click: makeUserBillUnpaid(paid_bill.id)" class="text-center danger-hover"><span class="glyphicon glyphicon-remove icon-color"></span></td>
                <td v-on="click:deleteUserBill(paid_bill.id)" class="text-center danger-hover"><span class="glyphicon glyphicon-trash icon-color"></span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- END Paid bills -->
    <div v-show="paid_bills.total < 1 && !loading_user_paid_bills" class="alert alert-danger">{{ trans('users_manager.user_has_no_paid_bills') }}</div>
</div>
<!-- END Paid bills tab content -->