@extends('layout.index')
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
                    <li v-on="click:getUserCustomProducts">
                        <a data-toggle="tab" href="#custom-products-tab">{{ trans('users_manager.custom_products') }}</a>
                    </li>
                    <!-- END Custom products -->

                    <!-- BEGIN Statistics -->
                    <li>
                        <a data-toggle="tab" href="#statistics-tab">{{ trans('users_manager.statistics') }}</a>
                    </li>
                    <!-- END Statistics -->

                    <!-- BEGIN Actions -->
                    <li v-on="click:getUserActions(false)">
                        <a data-toggle="tab" href="#actions-tab">{{ trans('users_manager.actions') }}</a>
                    </li>
                    <!-- END Actions -->
                </ul>

                <div class="tab-content">
                    @include('admin-center.users-manager.partials.bills-tab')

                    @include('admin-center.users-manager.partials.paid-bills-tab')

                    @include('admin-center.users-manager.partials.clients-tab')

                    @include('admin-center.users-manager.partials.custom-products-tab')

                    <!-- BEGIN Statistics tab content -->
                    <div id="statistics-tab" class="tab-pane fade">
                        <h3>{{ trans('users_manager.statistics') }}</h3>
                        <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
                    </div>
                    <!-- END Statistics tab content -->

                    @include('admin-center.users-manager.partials.actions-tab')

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