@extends('layout.index')
@section('content')

<!-- BEGIN Bills page -->
<div id="bills">

    @include('includes.ajax-translations.bills')

    <!-- BEGIN Bills table -->
    <div id="table" v-show="loaded">

        @include('bills.partials._add-bill-button')

        @if (!$validSubscription)
            @include('includes.alerts.expired-subscription')
        @else
            @include('bills.partials._no-bills-info')
        @endif

        @include('bills.partials._no-search-results')

        <!-- BEGIN Bills table-->
        <div class="panel panel-default" v-show="bills.total">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        @include('bills.partials._client')
                        @include('bills.partials._number-of-products')
                        @include('bills.partials._price')
                        @include('bills.partials._campaign-order')
                        @include('bills.partials._campaign')
                        @include('bills.partials._payment-term')
                        @include('bills.partials._delete')
                    </tr>
                </thead>

                <tbody>
                    <tr v-repeat="bill in bills.data">
                        @include('bills.partials._client-value')
                        @include('bills.partials._number-of-products-value')
                        @include('bills.partials._price-value')
                        @include('bills.partials._campaign-order-value')
                        @include('bills.partials._campaign-value')
                        @include('bills.partials._payment-term-value')
                        @include('bills.partials._delete-value')
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END Bills table -->

        @include('bills.partials._pagination')

    </div>
    <!-- END Bills table -->

    @include('includes.modals.create-bill')
    @include('includes.modals.help.how-to-create-bills')

</div>
<!-- END Bills page -->
@endsection

@section('scripts')
    <script src="/js/bills.js"></script>
@endsection