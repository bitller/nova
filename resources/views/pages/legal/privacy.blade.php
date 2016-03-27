@extends('layout.welcome.index')
@section('content')

    <div class="container-fluid privacy-content">
        <!-- BEGIN Page short description -->
        <div class="row">
            <div class="container">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-12 col-md-offset-0 col-lg-12 col-lg-offset-0 privacy">
                    <h3 class="grey-text">{{ trans('welcome.privacy_policy') }}</h3>
                </div>
            </div>
        </div>
        <!-- END Page short description -->

        <div class="row">
            <div class="container">
                <div class="well custom-well col-md-12 col-lg-12">
                    <h4 class="revision"><span class="label label-success">{{ trans('welcome.revision_date') }}: 22.04.2016</span></h4>
                    <p>Bitller Societate cu Raspundere Limitata ("Bitller SRL") operates several websites, including nova-manager.com. It is Bitller SRL's policy to respect your privacy regarding any information we may collect while operating our websites.</p>

                    <!-- BEGIN Website visitors title -->
                    <h4 class="top-bottom-space"><strong>{{ trans('welcome.website_visitors') }}</strong></h4>
                    <!-- END Website visitors title -->

                    <!-- BEGIN Website visitors content -->
                    <p class="bottom-space">Like most website operators, Bitller SRL collects non-personally-identifying information of the sort that web browsers and servers typically make available, such as the browser type, language preference, referring site, and the date and time of each visitor request. Bitller SRL’s purpose in collecting non-personally identifying information is to better understand how Bitller SRL’s visitors use its website. From time to time, Bitller SRL may release non-personally-identifying information in the aggregate, e.g., by publishing a report on trends in the usage of its website.</p>
                    <!-- END Website visitors content -->

                    <!-- BEGIN Gathering of Personally-Identifying Information title -->
                    <h4 class="bottom-space"><strong>{{ trans('welcome.gathering_personal_information') }}</strong></h4>
                    <!-- END Gathering of Personally-Identifying Information title -->

                    <!-- BEGIN Gathering of Personally-Identifying Information content -->
                    <p class="bottom-space">Certain visitors to nova-manager.com choose to interact with the website in ways that require Bitller SRL to gather personally-identifying information. The amount and type of information that Bitller SRL gathers depends on the nature of the interaction. For example, we ask visitors who sign up for a free account to provide their name and email address. Those who engage in transactions with Bitller SRL - by purchasing subscriptions, for example - are asked to provide additional information, including as necessary the personal and financial information required to process those transactions. In each case, Bitller SRL collects such information only insofar as is necessary or appropriate to fulfill the purpose of the visitor’s interaction with nova-manager.com. Bitller SRL does not disclose personally-identifying information other than as described below. And visitors can always refuse to supply personally-identifying information, with the caveat that it may prevent them from engaging in certain website-related activities.</p>
                    <!-- END Gathering of Personally-Identifying Information content -->

                    <!-- BEGIN Uses of Gathered Information title -->
                    <h4 class="bottom-space">
                        <strong>{{ trans('privacy.use_of_gathered_information') }}</strong>
                    </h4>
                    <!-- END Uses of Gathered Information title -->

                    <!-- BEGIN Uses of Gathered Information content -->
                    <p class="bottom-space">{{ trans('privacy.user_of_gathered_information_content') }}</p>
                    <!-- END Uses of Gathered Information content -->

                </div>
            </div>
        </div>

    </div>

@endsection