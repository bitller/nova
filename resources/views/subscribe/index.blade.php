@extends('layout.index')
@section('content')

@include('includes.ajax-translations.subscribe')

        <!-- BEGIN Subscribe -->
<div id="subscribe" class="row">

    <div class="col-sm-12 col-md-12 col-lg-12">

        <!-- BEGIN Custom well -->
        <div class="well custom-well">

            <!-- BEGIN End of free period alert row -->
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    @include('subscribe.index-partials._end-of-free-period-alert')
                </div>
            </div>
            <!-- END End of free period alert row -->

            <!-- BEGIN Payment methods row -->
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    @include('subscribe.index-partials._card-payment-method')
                    @include('subscribe.index-partials._bank-payment-method')
                </div>
            </div>
            <!-- END Payment methods row -->

        </div>
        <!-- END Custom well -->

    </div>
    <input class="card-amount-int" type="hidden" v-model="amount" value="15" />
    <input class="card-currency" type="hidden" v-model="currency" value="EUR" />

</div>
<!-- END Subscribe -->

@endsection

@section('scripts')
    <script type="text/javascript" src="https://bridge.paymill.com/"></script>
    <script type="text/javascript">
        var PAYMILL_PUBLIC_KEY = '670897165999c7209df7ec84d1d5a55b';
    </script>
    <script type="text/javascript" src="/js/subscribe.js"></script>
@endsection