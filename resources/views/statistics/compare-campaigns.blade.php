@extends('layout')
@section('content')
    <div class="compare-campaigns" v-show="!loading" campaign-number="{{ $campaignNumber }}" campaign-year="{{ $campaignYear }}" other-campaign-number="{{ $otherCampaignNumber }}" other-campiagn-year="{{ $otherCampaignYear }}">

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
                    <span class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span class="medium-text">40% mai multe incasari</span>
                    <div>
                        <span class="grey-text">In aceasta campanie ai avut incasari mai mari cu 2033 ron decat in campania 1/2016</span>
                    </div>
                </div>

                <div class="col-xs-5 text-center">
                    <canvas id="myChart" width="120" height="120"></canvas>

                </div>

            </div>
            <!-- END Earnings -->

            <div class="divider"></div>

            <!-- BEGIN Number of clients -->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1">
                    <span class="glyphicon glyphicon-arrow-down big-icon"></span>
                    <span class="medium-text">10% mai putini clienti</span>
                    <div>
                        <span class="grey-text">In aceasta campania ai avut o scadere a numarului de clienti, mai exact cu 5 mai putini. Campania trecuta ai avut 50 de client, acum 45.</span>
                    </div>
                </div>
            </div>
            <!-- END Number of clients -->

            <!-- BEGIN Number of bills -->
            <!-- END Number of bills -->

            <!-- BEGIN Offered discount -->
            <!-- END Offered discount -->

            <!-- BEGIN Sold products -->
            <!-- END Sold products -->

            <!-- BEGIN Products per day sold -->
            <!-- END Products per day sold -->

        </div>

    </div>
@endsection

@section('scripts')
    <script src="/js/compare-campaigns.js"></script>
@endsection