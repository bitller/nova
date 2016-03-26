@extends('layout.index')
@section('content')

    @include('includes.ajax-translations.subscribe')

    <!-- BEGIN Subscribe -->
    <div id="subscribe" class="row">

        <!-- BEGIN Custom well -->
        <div class="well custom-well">

            <!-- BEGIN Card number and card holder row -->
            <div class="row">

                <!-- BEGIN Card number -->
                <div class="col-md-6">
                    <div class="form-group" v-class="has-error : card_number_error">
                        <label for="card-number">Card number:</label>
                        <input type="text" class="form-control" v-model="card_number" id="card-number">
                        <span class="text-danger" v-show="card_number_error">@{{ card_number_error }}</span>
                    </div>
                </div>
                <!-- END Card number -->

                {{--</div>--}}
                {{--<div class="row">--}}
                <div class="col-md-6">
                    <!-- BEGIN Card cvc -->
                    <div class="form-group" v-class="has-error : card_cvc_error">
                        <label for="card-cvc">CVC:</label>
                        <input type="text" class="form-control" v-model="card_cvc" id="card-cvc">
                        <span class="text-danger" v-show="card_cvc_error">@{{ card_cvc_error }}</span>
                    </div>
                    <!-- END Card cvc -->
                </div>
            </div>
            <!-- END Card number and card holder row -->

            <div class="row">
                <div class="col-md-6">
                    <!-- BEGIN Card holder -->
                    <div class="form-group" v-class="has-error : card_holder_error">
                        <label for="card-holdername">Name</label>
                        <input type="text" class="form-control" v-model="card_holdername" id="card-holdername">
                        <span class="text-danger" v-show="card_holder_error">@{{ card_holder_error }}</span>
                    </div>
                    <!-- END Card holder -->
                </div>

                <div class="col-md-6">
                    <!-- BEGIN Card expiry -->
                    <div class="form-group" v-class="has-error : card_expiry_date_error">
                        <label for="card-expiry-month">Expiry month</label>
                        <input type="text" class="form-control" v-model="card_expiry_month" id="card-expiry-month">
                        <label for="card-expiry-year">Expiry year</label>
                        <input type="text" class="form-control" v-model="card_expiry_year" id="card-expiry-year">
                        <span class="text-danger" v-show="card_expiry_date_error">@{{ card_expiry_date_error }}</span>
                    </div>
                    <!-- END Card expiry -->
                </div>
            </div>
        </div>
        <!-- END Custom well -->

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