@extends('layout')
@section('content')
    <div id="compare-campaigns" v-show="!loading" campaign-number="{{ $campaignNumber }}" campaign-year="{{ $campaignYear }}" other-campaign-number="{{ $otherCampaignNumber }}" other-campiagn-year="{{ $otherCampaignYear }}">

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

                <div class="col-xs-5 text-center">
                    <canvas id="number-of-clients-chart" width="530" height="120"></canvas>
                </div>

            </div>
            <!-- END Number of clients -->

            <div class="divider"></div>

            <!-- BEGIN Number of bills -->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1">
                    <span class="glyphicon glyphicon-arrow-down big-icon"></span>
                    <span class="medium-text">10% mai putine facturi</span>
                    <div>
                        <span class="grey-text">In campania 2/2016 ai avut o scadere a numarului de facturi, cu 10 mai putine. In campania 1/2016 ai avut 70 de facturi, iar in campania 1/2016 60 de facturi.</span>
                    </div>
                </div>
            </div>
            <!-- END Number of bills -->

            <div class="divider"></div>

            <!-- BEGIN Offered discount -->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1">
                    <span class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span class="medium-text">Reduceri cu 20% mai mari</span>
                    <div>
                        <span class="grey-text">In campania 2/2016 ai oferit reduceri in valoare de 1023 ron, in cresetere cu 200 ron fata de campania 1/2016</span>
                    </div>
                </div>
            </div>
            <!-- END Offered discount -->

            <div class="divider"></div>

            <!-- BEGIN Sold products -->
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1">
                    <span class="glyphicon glyphicon-arrow-up green-big-icon"></span>
                    <span class="medium-text">Ai vandut cu 34% mai multe produse</span>
                    <div>
                        <span class="grey-text">In campania 2/2016 ai vandut 289 produse, in crestere cu 32 de produse fata de campania 1/2016</span>
                    </div>
                </div>
            </div>
            <!-- END Sold products -->
        </div>

    </div>
@endsection

@section('scripts')
    <script src="/js/compare-campaigns.js"></script>
@endsection