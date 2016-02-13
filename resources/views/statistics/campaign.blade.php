@extends('layout')
@section('content')
    <div id="campaign-statistics" class="container" v-show="!loading" campaign-number="{{ $campaignNumber }}" campaign-year="{{ $campaignYear }}">

        @include('includes.ajax-translations.common')

        <!-- BEGIN Top part -->
        <div class="add-client-button">
            <span class="my-clients-title">
                <span>{{ trans('statistics.campaign_statistics') . " $campaignNumber/$campaignYear" }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('clients.number_of_paid_bills') }}"></span></span>
            </span>
            <button v-on="click: getCampaignsYears" type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#compare-campaigns-modal">
                <span class="glyphicon glyphicon-duplicate"></span> {{ trans('statistics.compare') }}
            </button>
        </div>
        <!-- END Top part -->

        <div class="well custom-well">

            <!-- BEGIN First row -->
            <div class="row">
                <!-- BEGIN Total sum of orders -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-usd big-icon"></span>
                    <span class="big-text">@{{ statistics.total_bills_price }} ron</span>
                    <div class="grey-text">{{ trans('statistics.value_of_all_orders') }}</div>
                </div>
                <!-- END Total sum of orders -->

                <!-- BEGIN Number of clients who ordered in this campaign -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-user big-icon"></span>&nbsp;
                    <span class="big-text">@{{ statistics.number_of_clients }} {{ trans('statistics.of_clients') }}</span>
                    <div class="grey-text">{{ trans('statistics.ordered_in_this_campaign') }}</div>
                </div>
                <!-- END Number of clients who ordered in this campaign -->
            </div>
            <!-- END First row -->

            <div class="divider"></div>

            <!-- BEGIN Second row -->
            <div class="row">

                <!-- BEGIN Number of created bills -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-list-alt big-icon"></span>&nbsp;
                    <span class="big-text">@{{ statistics.number_of_bills }} {{ trans('statistics.of_bills') }}</span>
                    <div class="grey-text">{{ trans('statistics.have_been_created') }}</div>
                </div>
                <!-- END Number of created bills -->

                <!-- BEGIN Total discount offered -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-stats big-icon"></span>&nbsp;
                    <span class="big-text">@{{ statistics.total_discount }} ron</span>
                    <div class="grey-text">{{ trans('statistics.offered_discount') }}</div>
                </div>
                <!-- END Total discount offered -->

            </div>
            <!-- END Second row -->

            <div class="divider"></div>

            <!-- BEGIN Third row -->
            <div class="row">

                <!-- BEGIN Number of products sold -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-th big-icon"></span>&nbsp;
                    <span class="big-text">@{{ statistics.number_of_sold_products }} {{ trans('statistics.products') }}</span>
                    <div class="grey-text">{{ trans('statistics.sold_in_this_campaign') }}</div>
                </div>
                <!-- END Number of products sold -->

                <!-- BEGIN Number of products sold per day -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-th-large big-icon"></span>&nbsp;
                    <span class="big-text">@{{ statistics.products_sold_per_day }} {{ trans('statistics.products_day') }}</span>
                    <div class="grey-text">{{ trans('statistics.sold') }}</div>
                </div>
                <!-- END Number of products sold per day -->

            </div>
            <!-- END Third row -->

            <div class="divider"></div>

            <!-- BEGIN Fourth row -->
            <div class="row">
                <!-- BEGIN Cashed bills -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-ok big-icon"></span>&nbsp;
                    <span class="big-text">@{{ statistics.number_of_cashed_bills }} {{ trans('statistics.bills') }}</span>
                    <div class="grey-text">{{ trans('statistics.cashed_bills') }}</div>
                </div>
                <!-- END Cashed bills -->

                <!-- BEGIN Cashed bills sum -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-usd big-icon"></span>
                    <span class="big-text">@{{ statistics.cashed_money }} ron</span>
                    <div class="grey-text">{{ trans('statistics.sum_already_cashed') }}</div>
                </div>
                <!-- END Cashed bills sum -->
            </div>
            <!-- END Fourth row -->

            <div class="divider"></div>

            <!-- BEGIN Fifth row -->
            <div class="row">

                <!-- BEGIN Bills with payment term passed -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-calendar big-icon"></span>&nbsp;
                    <span class="big-text">@{{ statistics.number_of_bills_with_passed_payment_term }} {{ trans('statistics.bills') }}</span>
                    <div class="grey-text">{{ trans('statistics.with_passed_payment_term') }}</div>
                </div>
                <!-- END Bills with payment term passed -->

                <!-- BEGIN Money to receive -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-usd big-icon"></span>
                    <span class="big-text">@{{ statistics.money_to_receive }} ron</span>
                    <div class="grey-text">{{ trans('statistics.to_receive') }}</div>
                </div>
                <!-- END Money to receive -->

            </div>
            <!-- END Fifth row -->

        </div>

        @include('includes.modals.compare-campaigns-modal')

    </div>
@endsection

@section('scripts')
    <script src="/js/vendor.js"></script>
    <script src="/js/header-search.js"></script>
    <script src="/js/campaign-statistics.js"></script>
@endsection
