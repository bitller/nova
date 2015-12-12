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

            <h4 class="user-email">user@bitller.com</h4>

            <!-- BEGIN User options -->
            <div class="btn-group user-options">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-th-large"></span>&nbsp;
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">

                    <!-- BEGIN Edit email -->
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-envelope"></span>&nbsp; {{ trans('users_manager.edit_email') }}
                        </a>
                    </li>
                    <!-- END Edit email -->

                    <!-- BEGIN Change password -->
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-lock"></span>&nbsp; {{ trans('users_manager.change_password') }}
                        </a>
                    </li>
                    <!-- END Change password -->

                    <!-- BEGIN Disable account -->
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-off"></span>&nbsp; {{ trans('users_manager.disable_account') }}
                        </a>
                    </li>
                    <!-- END Disable account -->

                    <!-- BEGIN Enable account -->
                    <li>
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
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_account') }}
                        </a>
                    </li>
                    <!-- END Delete account -->

                </ul>
            </div>
            <!-- END User options -->

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
                    <li>
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

                        <h4 class="bill-title" v-show="!loading_user_bills">{{ trans('users_manager.bills_of_this_user') }}</h4>

                        <div class="btn-group bill-options" v-show="!loading_user_bills">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-th-large"></span>&nbsp;
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">
                                        <span class="glyphicon glyphicon-plus">&nbsp;</span> {{ trans('users_manager.create_bill') }}
                                    </a>
                                </li>
                                <li v-show="bills.total > 0">
                                    <a href="#" v-on="click: deleteAllUserBills">
                                        <span class="glyphicon glyphicon-trash">&nbsp;</span> {{ trans('users_manager.delete_all_bills') }}
                                    </a>
                                </li>
                                <li v-show="bills.total > 0">
                                    <a href="#" v-on="click: makeAllUserBillsPaid">
                                        <span class="glyphicon glyphicon-ok">&nbsp;</span> {{ trans('users_manager.mark_all_bills_as_paid') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- BEGIN User bills -->
                        <div class="panel panel-default" v-show="!loading_user_bills && bills.total > 0">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ trans('users_manager.client') }}</th>
                                    <th>{{ trans('users_manager.order') }}</th>
                                    <th>{{ trans('users_manager.campaign') }}</th>
                                    <th>{{ trans('users_manager.price') }}</th>
                                    <th>{{ trans('users_manager.created_at') }}</th>
                                    <th>{{ trans('users_manager.mark_as_paid') }}</th>
                                    <th>{{ trans('users_manager.delete_bill') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-repeat="bill in bills.data">
                                    <td>@{{ bill.client_name }}</td>
                                    <td class="text-center">@{{ bill.campaign_order }}</td>
                                    <td class="text-center">@{{ bill.campaign_number }}</td>
                                    <td class="text-center">@{{ bill.price }}</td>
                                    <td class="text-center">@{{ bill.created_at }}</td>
                                    <td class="text-center primary-hover"><span class="glyphicon glyphicon-ok icon-color"></span></td>
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

                        <h4 v-show="!loading_user_paid_bills">{{ trans('users_manager.paid_bills_of_this_user') }}</h4>

                        <!-- BEGIN Paid bills -->
                        <div class="panel panel-default" v-show="!loading_user_paid_bills && paid_bills.total > 0">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ trans('users_manager.client') }}</th>
                                    <th>{{ trans('users_manager.order') }}</th>
                                    <th>{{ trans('users_manager.campaign') }}</th>
                                    <th>{{ trans('users_manager.price') }}</th>
                                    <th>{{ trans('users_manager.created_at') }}</th>
                                    <th>{{ trans('users_manager.mark_as_unpaid') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-repeat="paid_bill in paid_bills.data">
                                    <td>@{{ paid_bill.client_name }}</td>
                                    <td class="text-center">@{{ paid_bill.campaign_order }}</td>
                                    <td class="text-center">@{{ paid_bill.campaign_number }}</td>
                                    <td class="text-center">@{{ paid_bill.price }}</td>
                                    <td class="text-center">@{{ paid_bill.created_at }}</td>
                                    <td class="text-center"><span class="glyphicon glyphicon-ok icon-color"></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- END Paid bills -->
                        <div v-show="paid_bills.total < 1 && !loading_user_paid_bills" class="alert alert-danger">{{ trans('users_manager.user_has_no_paid_bills') }}</div>
                    </div>
                    <!-- END Paid bills tab content -->

                    <!-- BEGIN Clients tab content -->
                    <div id="clients-tab" class="tab-pane fade">
                        <h3>{{ trans('users_manager.clients') }}</h3>
                        <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
                    </div>
                    <!-- END Clients tab content -->

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

    </div>
@endsection

@section('scripts')
    <script src="/js/user.js"></script>
@endsection