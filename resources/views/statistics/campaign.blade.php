@extends('layout')
@section('content')
    <div id="campaign-statistics" class="container" campaign-number="{{ $campaignNumber }}" campaign-year="{{ $campaignYear }}">

        <!-- BEGIN Top part -->
        <div class="add-client-button">
            <span class="my-clients-title">
                <span>{{ trans('statistics.campaign_statistics') . " $campaignNumber/$campaignYear" }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('clients.number_of_paid_bills') }}"></span></span>
            </span>
            <button type="button" class="btn btn-primary pull-right">
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
                    <span class="big-text">1932.21 ron</span>
                    <div>{{ trans('statistics.value_of_all_orders') }}</div>
                </div>
                <!-- END Total sum of orders -->

                <!-- BEGIN Number of clients who ordered in this campaign -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-user big-icon"></span>
                    <span class="big-text">94 {{ trans('statistics.of_clients') }}</span>
                    <div>{{ trans('statistics.ordered_in_this_campaign') }}</div>
                </div>
                <!-- END Number of clients who ordered in this campaign -->
            </div>
            <!-- END First row -->

            <div class="divider"></div>

            <!-- BEGIN Second row -->
            <div class="row">

                <!-- BEGIN Number of created bills -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-list-alt big-icon"></span>
                    <span class="big-text">105 {{ trans('statistics.of_bills') }}</span>
                    <div>{{ trans('statistics.have_been_created') }}</div>
                </div>
                <!-- END Number of created bills -->

                <!-- BEGIN Total discount offered -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-stats big-icon"></span>
                    <span class="big-text">2812 ron</span>
                    <div>{{ trans('statistics.offered_discount') }}</div>
                </div>
                <!-- END Total discount offered -->

            </div>
            <!-- END Second row -->

            <div class="divider"></div>

            <!-- BEGIN Third row -->
            <div class="row">

                <!-- BEGIN Number of products sold -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-th big-icon"></span>
                    <span class="big-text">5644</span>
                    <div>{{ trans('statistics.products_sold_in_this_campaign') }}</div>
                </div>
                <!-- END Number of products sold -->

                <!-- BEGIN Number of products sold per day -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-th-large big-icon"></span>
                    <span class="big-text">204 {{ trans('statistics.products_day') }}</span>
                    <div>{{ trans('statistics.sold') }}</div>
                </div>
                <!-- END Number of products sold per day -->

            </div>
            <!-- END Third row -->

            <div class="divider"></div>

            <!-- BEGIN Fourth row -->
            <div class="row">
                <!-- BEGIN Cashed bills -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-ok big-icon"></span>
                    <span class="big-text">142 {{ trans('statistics.bills') }}</span>
                    <div>{{ trans('statistics.cashed_bills') }}</div>
                </div>
                <!-- END Cashed bills -->

                <!-- BEGIN Cashed bills sum -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-usd big-icon"></span>
                    <span class="big-text">4329 ron</span>
                    <div>{{ trans('statistics.sum_already_cashed') }}</div>
                </div>
                <!-- END Cashed bills sum -->
            </div>
            <!-- END Fourth row -->

            <div class="divider"></div>

            <!-- BEGIN Fifth row -->
            <div class="row">

                <!-- BEGIN Bills with payment term passed -->
                <div class="col-xs-5 col-xs-offset-1 text-center">
                    <span class="glyphicon glyphicon-calendar big-icon"></span>
                    <span class="big-text">40 {{ trans('statistics.bills') }}</span>
                    <div>{{ trans('statistics.with_passed_payment_term') }}</div>
                </div>
                <!-- END Bills with payment term passed -->

                <!-- BEGIN Money to receive -->
                <div class="col-xs-5 text-center">
                    <span class="glyphicon glyphicon-usd big-icon"></span>
                    <span class="big-text">134 ron</span>
                    <div>{{ trans('statistics.to_receive') }}</div>
                </div>
                <!-- END Money to receive -->

            </div>
            <!-- END Fifth row -->

        </div>
    </div>
@endsection