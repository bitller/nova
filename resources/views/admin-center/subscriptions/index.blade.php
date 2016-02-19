@extends('layout.index')
@section('content')
    <div id="subscriptions">
        @include('includes.ajax-translations.common')
        <div>
            <!-- BEGIN Top part -->
            <div class="add-product-button row">
                <span class="admin-center-title">{{ trans('subscriptions.subscriptions') }}</span>&nbsp;

                @include('includes.admin-center.buttons.more-options-dropdown', [
                    'icon' => 'glyphicon-th',
                    'items' => [
                        [
                            'url' => '/admin-center/subscriptions/offers',
                            'name' => trans('subscriptions.offers'),
                            'icon' => 'glyphicon-list-alt'
                        ],
                        [
                            'url' => '#',
                            'name' => trans('subscriptions.create_new_subscription'),
                            'icon' => 'glyphicon-plus',
                            'data_toggle' => 'modal',
                            'data_target' => '#create-new-subscription-modal'
                        ]
                    ]
                ])

                <div class="btn-group pull-right">
                    @include('includes.admin-center.buttons.more')
                </div>
            </div>
            <!-- END Top part -->

            <div class="row">
            <!-- BEGIN User details -->
            <div class="well custom-well">
                <ul class="nav nav-tabs">

                    <!-- BEGIN Active subscriptions tab -->
                    <li class="active">
                        <a data-toggle="tab" href="#active-subscriptions-tab">{{ trans('subscriptions.active_subscriptions') }}</a>
                    </li>
                    <!-- END Active subscriptions tab -->

                    <!-- BEGIN Waiting subscriptions tab -->
                    <li v-on="click: getWaitingSubscriptions">
                        <a data-toggle="tab" href="#waiting-subscriptions-tab">{{ trans('subscriptions.waiting_subscriptions') }}</a>
                    </li>
                    <!-- END Waiting subscriptions tab -->

                    <!-- BEGIN Canceled subscriptions tab -->
                    <li v-on="click:getUserPaidBills">
                        <a data-toggle="tab" href="#paid-bills-tab">{{ trans('subscriptions.canceled_subscriptions') }}</a>
                    </li>
                    <!-- END Canceled subscriptions tab -->

                    <!-- BEGIN Failed subscriptions tab -->
                    <li v-on="click:getUserClients">
                        <a data-toggle="tab" href="#clients-tab">{{ trans('subscriptions.failed_subscriptions') }}</a>
                    </li>
                    <!-- END Failed subscriptions tab -->

                    <!-- BEGIN Statistics tab -->
                    <li v-on="click:getUserCustomProducts">
                        <a data-toggle="tab" href="#custom-products-tab">{{ trans('subscriptions.statistics') }}</a>
                    </li>
                    <!-- END Statistics tab -->

                </ul>

                <div class="tab-content">
                    @include('admin-center.subscriptions.partials.active-subscriptions-tab')

                    @include('admin-center.subscriptions.partials.waiting-subscriptions-tab')

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

            @include('includes.modals.create-new-subscription')

        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/subscriptions-index.js"></script>
@endsection