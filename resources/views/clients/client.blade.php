@extends('layout.index')
@section('content')

    @include('includes.ajax-translations.client')

    <div id="client" client-id="{{ $clientId }}">

        <div class="container" v-show="loaded">

            @include('clients.client-partials._top-part')

            <!-- BEGIN Primary divider -->
            <div class="ff-primary-divider">
                @include('clients.client-partials._email')
                @include('clients.client-partials._phone-number')
                @include('clients.client-partials._number-of-orders')
            </div>
            <!-- END Primary divider -->

            <!-- BEGIN Content -->
            <div class="ff-content">
                <div class="row">
                    @include('clients.client-partials._money-user-has-to-receive')
                    @include('clients.client-partials._money-owed-due-passed-payment-term')
                </div>

                <div class="row">
                    @include('clients.client-partials._money-generated-by-this-client')
                    @include('clients.client-partials._number-of-products-ordered')
                </div>

                <div class="row">
                    @include('clients.client-partials._money-generated-by-this-client-this-year')
                    @include('clients.client-partials._number-of-products-ordered-this-year')
                </div>

                <div class="row">
                    @include('clients.client-partials._statistics-info')
                </div>

            </div>
            <!-- END Content -->

            @include('clients.client-partials._last-paid-bills')
            @include('clients.client-partials._last-unpaid-bills')

            <!-- End of the content -->
            <div class="ff-content-end"></div>

            <!-- Include modals -->
            @include('includes.modals.edit-client-name')
            @include('includes.modals.edit-client-email')
            @include('includes.modals.edit-client-phone-number')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/client.js"></script>
@endsection