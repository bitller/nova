@extends('layout')
@section('content')
    <div id="compare-campaigns" v-show="!loading" campaign-number="{{ $campaignNumber }}" campaign-year="{{ $campaignYear }}" other-campaign-number="{{ $otherCampaignNumber }}" other-campaign-year="{{ $otherCampaignYear }}">

        @include('includes.ajax-translations.common')

        <!-- BEGIN Top part -->
        <div class="add-client-button">
            <span class="my-clients-title">
                <span>
                    {{ trans('statistics.compare_campaign') }} <a href="#">{{  " $campaignNumber/$campaignYear " }}</a> {{ trans('statistics.with_campaign') }} <a href="#">{{ " $otherCampaignNumber/$otherCampaignYear" }}</a>
                    <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('clients.number_of_paid_bills') }}"></span>
                </span>
            </span>
        </div>
        <!-- END Top part -->

        <div class="well custom-well">

            <!-- BEGIN Earnings -->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1">

                    <span v-show="sales_plus" class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span v-show="sales_minus" class="glyphicon glyphicon-arrow-down big-icon"></span>
                    <span v-show="sales_equal" class="glyphicon glyphicon-resize-horizontal big-icon"></span>

                    <span class="medium-text">@{{ sales_title }}</span>
                    <div>
                        <span class="grey-text">@{{ sales_message }}</span>
                    </div>
                </div>

                <div class="col-xs-5 text-center">
                    <canvas id="sales-chart" width="530" height="120"></canvas>
                </div>

            </div>
            <!-- END Earnings -->

            <div class="divider"></div>

            <!-- BEGIN Number of clients -->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1">

                    <span v-show="number_of_clients_plus" class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span v-show="number_of_clients_minus" class="glyphicon glyphicon-arrow-down big-icon"></span>
                    <span v-show="number_of_clients_equal" class="glyphicon glyphicon-resize-horizontal big-icon"></span>

                    <span class="medium-text">@{{ clients_title }}</span>
                    <div>
                        <span class="grey-text">@{{ clients_message }}</span>
                    </div>
                </div>

                <div class="col-xs-5 text-center">
                    <canvas id="clients-chart" width="530" height="120"></canvas>
                </div>

            </div>
            <!-- END Number of clients -->

            <div class="divider"></div>

            <!-- BEGIN Number of bills -->
            <div class="row">

                <div class="col-xs-5 col-xs-offset-1">

                    <span v-show="number_of_bills_plus" class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span v-show="number_of_bills_minus" class="glyphicon glyphicon-arrow-down big-icon"></span>
                    <span v-show="number_of_bills_equal" class="glyphicon glyphicon-resize-horizontal big-icon"></span>

                    <span class="medium-text">@{{ bills_title }}</span>
                    <div>
                        <span class="grey-text">@{{ bills_message }}</span>
                    </div>
                </div>

                <div class="col-xs-5 text-center">
                    <canvas id="bills-chart" width="530" height="120"></canvas>
                </div>
            </div>
            <!-- END Number of bills -->

            <div class="divider"></div>

            <!-- BEGIN Offered discount -->
            <div class="row">

                <div class="col-xs-5 col-xs-offset-1">

                    <span v-show="discount_plus" class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span v-show="discount_minus" class="glyphicon glyphicon-arrow-down big-icon"></span>
                    <span v-show="discount_equal" class="glyphicon glyphicon-resize-horizontal big-icon"></span>

                    <span class="medium-text">@{{ discount_title }}</span>
                    <div>
                        <span class="grey-text">@{{ discount_message }}</span>
                    </div>
                </div>

                <div class="col-xs-5 text-center">
                    <canvas id="discount-chart" width="530" height="120"></canvas>
                </div>

            </div>
            <!-- END Offered discount -->

            <div class="divider"></div>

            <!-- BEGIN Sold products -->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1">

                    <span v-show="sold_products_plus" class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span v-show="sold_products_minus" class="glyphicon glyphicon-arrow-down big-icon"></span>
                    <span v-show="sold_products_equal" class="glyphicon glyphicon-resize-horizontal big-icon"></span>

                    <span class="medium-text">@{{ sold_products_title }}</span>
                    <div>
                        <span class="grey-text">@{{ sold_products_message }}</span>
                    </div>
                </div>

                <div class="col-xs-5 text-center">
                    <canvas id="sold-products-chart" width="530" height="120"></canvas>
                </div>

            </div>
            <!-- END Sold products -->
        </div>

    </div>
@endsection

@section('scripts')
    <script src="/js/compare-campaigns.js"></script>
@endsection