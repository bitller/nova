@extends('layout.index')

@section('styles')
    <link rel="stylesheet" media="print" href="/css/print.css">
@endsection

    @section('content')
    @include('includes.ajax-translations.bill')

    <!-- BEGIN Bill -->
    <div id="bill" bill-id="{{ $billId }}" v-show="loaded">

        <div class="col-md-12">

            @include('bill.partials._bill-top-part')

            @include('bill.partials._payment-term-not-set-warning')

            @include('bill.partials._payment-term-passed')

            @include('bill.partials._bill-table')

            @include('bill.partials._unavailable-products')

            @include('bill.partials._other-details')

            @include('bill.partials._payment-term')

            <div class="col-md-2"></div>

            @include('bill.partials._total-price')

            <div class="col-md-2"></div>

            @include('bill.partials._total-discount')

            @include('bill.partials._empty-bill-alert')

            @include('bill.partials._details-visible-on-printed-bill-only')

        </div>

        <!-- BEGIN Include modals -->
        @include('includes.modals.add-product-to-bill')
        @include('includes.modals.other-details')
        @include('includes.modals.payment-term')
        <!-- END Include modals -->

    </div>
    <!-- END Bill -->
@endsection
@section('scripts')
    <script src="/js/bill.js"></script>
@endsection