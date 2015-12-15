@extends('layout')
@section('content')
    @include('includes.ajax-translations.users-manager')
    <div id="user" user-id="{{ $userId }}">

        <!-- BEGIN Top part -->
        <div class="add-product-button row">

            <a href="/admin-center/users-manager"><button class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;{{ trans('users_manager.go_back') }}</button></a>

            <div class="btn-group pull-right">
                @include('includes.admin-center.buttons.subscriptions')
                @include('includes.admin-center.buttons.products-manager')
                @include('includes.admin-center.buttons.logs')
                @include('includes.admin-center.buttons.application-settings')
                @include('includes.admin-center.buttons.more')
            </div>
        </div>
        <!-- END Top part -->

        <!-- BEGIN User -->
        <div class="row">

            <div v-show="!loading_user_bills" class="dropdown">
                <h4 class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="user-email">@{{ user_email }}</span><span class="caret"></span></h4>
                <ul class="dropdown-menu">

                    <!-- BEGIN Edit email -->
                    <li v-on="click: resetEditUserEmailModal" data-toggle="modal" data-target="#edit-user-email-modal">
                        <a href="#">
                            <span class="glyphicon glyphicon-envelope"></span>&nbsp; {{ trans('users_manager.edit_email') }}
                        </a>
                    </li>
                    <!-- END Edit email -->

                    <!-- BEGIN Change password -->
                    <li v-on="click: resetChangeUserPasswordModal" data-toggle="modal" data-target="#change-user-password-modal">
                        <a href="#">
                            <span class="glyphicon glyphicon-lock"></span>&nbsp; {{ trans('users_manager.change_password') }}
                        </a>
                    </li>
                    <!-- END Change password -->

                    <!-- BEGIN Disable account -->
                    <li v-show="active > 0" v-on="click: disableUserAccount">
                        <a href="#">
                            <span class="glyphicon glyphicon-off"></span>&nbsp; {{ trans('users_manager.disable_account') }}
                        </a>
                    </li>
                    <!-- END Disable account -->

                    <!-- BEGIN Enable account -->
                    <li v-show="active < 1" v-on="click: enableUserAccount">
                        <a href="#">
                            <span class="glyphicon glyphicon-ok"></span>&nbsp; {{ trans('users_manager.enable_account') }}
                        </a>
                    </li>
                    <!-- END Enable account -->

                    <!-- BEGIN Enable subscription -->
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-usd"></span>&nbsp; {{ trans('users_manager.enable_subscription') }}
                        </a>
                    </li>
                    <!-- END Enable subscription -->

                    <!-- BEGIN Disable subscription -->
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-remove">&nbsp;</span> {{ trans('users_manager.disable_subscription') }}
                        </a>
                    </li>
                    <!-- END Disable subscription -->

                    <!-- BEGIN Delete account -->
                    <li v-on="click: deleteUserAccount">
                        <a href="#">
                            <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_account') }}
                        </a>
                    </li>
                    <!-- END Delete account -->

                </ul>
            </div>

            <!-- BEGIN User details -->
            <div class="well custom-well">
                <ul class="nav nav-tabs">

                    <!-- BEGIN Bills tab -->
                    <li class="active">
                        <a data-toggle="tab" href="#bills-tab">{{ trans('users_manager.bills') }}</a>
                    </li>
                    <!-- END Bills tab -->

                    <!-- BEGIN Paid bills tab -->
                    <li v-on="click:getUserPaidBills">
                        <a data-toggle="tab" href="#paid-bills-tab">{{ trans('users_manager.paid_bills') }}</a>
                    </li>
                    <!-- END Paid bills tab -->

                    <!-- BEGIN Clients tab -->
                    <li v-on="click:getUserClients">
                        <a data-toggle="tab" href="#clients-tab">{{ trans('users_manager.clients') }}</a>
                    </li>
                    <!-- END Clients tab -->

                    <!-- BEGIN Custom products -->
                    <li>
                        <a data-toggle="tab" href="#custom-products-tab">{{ trans('users_manager.custom_products') }}</a>
                    </li>
                    <!-- END Custom products -->

                    <!-- BEGIN Statistics -->
                    <li>
                        <a data-toggle="tab" href="#statistics-tab">{{ trans('users_manager.statistics') }}</a>
                    </li>
                    <!-- END Statistics -->

                    <!-- BEGIN Actions -->
                    <li>
                        <a data-toggle="tab" href="#actions-tab">{{ trans('users_manager.actions') }}</a>
                    </li>
                    <!-- END Actions -->
                </ul>

                <div class="tab-content">
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

                    @include('admin-center.users-manager.partials.clients-tab')

                    <!-- BEGIN Custom products tab content -->
                    <div id="custom-products-tab" class="tab-pane fade">
                        <h3>{{ trans('users_manager.custom_products') }}</h3>
                        <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
                    </div>
                    <!-- END Custom products tab content -->

                    <!-- BEGIN Statistics tab content -->
                    <div id="statistics-tab" class="tab-pane fade">
                        <h3>{{ trans('users_manager.statistics') }}</h3>
                        <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
                    </div>
                    <!-- END Statistics tab content -->

                    <!-- BEGIN Actions tab content -->
                    <div id="actions-tab" class="tab-pane fade">
                        <h3>{{ trans('users_manager.actions') }}</h3>
                        <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
                    </div>
                    <!-- END Actions tab content  -->

                </div>
            </div>
            <!-- END Users details -->
        </div>
        <!-- END User -->

        @include('includes.modals.edit-user-email')
        @include('includes.modals.change-user-password')

    </div>
@endsection

@section('scripts')
    <script src="/js/user.js"></script>
@endsection