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
                <div class="col-md-12">
                    <div class="well custom-well">
                        <h4 class="revision"><span class="label label-success">{{ trans('welcome.revision_date') }}: 22.04.2016</span></h4>
                        <p>Bitller Societate cu Raspundere Limitata ("Bitller SRL") operates several websites, including nova-manager.com. It is Bitller SRL's policy to respect your privacy regarding any information we may collect while operating our websites.</p>

                        <!-- BEGIN Website visitors title -->
                        <h4 class="top-bottom-space"><strong>{{ trans('welcome.website_visitors') }}</strong></h4>
                        <!-- END Website visitors title -->

                        <!-- BEGIN Website visitors content -->
                        <p>Like most website operators, Bitller SRL collects non-personally-identifying information of the sort that web browsers and servers typically make available, such as the browser type, language preference, referring site, and the date and time of each visitor request. Bitller SRL’s purpose in collecting non-personally identifying information is to better understand how Bitller SRL’s visitors use its website. From time to time, Bitller SRL may release non-personally-identifying information in the aggregate, e.g., by publishing a report on trends in the usage of its website.</p>
                        <!-- END Website visitors content -->

                        <!-- BEGIN Gathering of Personally-Identifying Information title -->
                        <h4 class="bottom-space"><strong>{{ trans('welcome.gathering_personal_information') }}</strong></h4>
                        <!-- END Gathering of Personally-Identifying Information title -->

                        <!-- BEGIN Gathering of Personally-Identifying Information content -->
                        <p class="bottom-space">Certain visitors to nova-manager.com choose to interact with the website in ways that require Bitller SRL to gather personally-identifying information. The amount and type of information that Bitller SRL gathers depends on the nature of the interaction. For example, we ask visitors who sign up for a free account to provide their name and email address. Those who engage in transactions with Bitller SRL - by purchasing subscriptions, for example - are asked to provide additional information, including as necessary the personal and financial information required to process those transactions. In each case, Bitller SRL collects such information only insofar as is necessary or appropriate to fulfill the purpose of the visitor’s interaction with nova-manager.com. Bitller SRL does not disclose personally-identifying information other than as described below. And visitors can always refuse to supply personally-identifying information, with the caveat that it may prevent them from engaging in certain website-related activities.</p>
                        <!-- END Gathering of Personally-Identifying Information content -->

                        <!-- BEGIN Uses of Gathered Information title -->
                        <h4 class="bottom-space">
                            <strong>{{ trans('privacy.uses_of_gathered_information') }}</strong>
                        </h4>
                        <!-- END Uses of Gathered Information title -->

                        <!-- BEGIN Uses of Gathered Information content -->
                        <p class="bottom-space">{{ trans('privacy.uses_of_gathered_information_content') }}</p>
                        <ul>
                            <li class="bottom-space">
                                <strong>{{ trans('privacy.uses_of_gathered_information_content_1') }}</strong>
                                {{ trans('privacy.uses_of_gathered_information_content_2') }}
                            </li>
                            <li class="bottom-space">
                                <strong>{{ trans('privacy.uses_of_gathered_information_content_3') }}</strong>
                                {{ trans('privacy.uses_of_gathered_information_content_4') }}
                            </li>
                            <li class="bottom-space">
                                <strong>{{ trans('privacy.uses_of_gathered_information_content_5') }}</strong>
                                {{ trans('privacy.uses_of_gathered_information_content_6') }}
                            </li>
                        </ul>
                        <!-- END Uses of Gathered Information content -->

                        <!-- BEGIN Security of Gathered Information title -->
                        <h4 class="bottom-space">
                            <strong>{{ trans('privacy.security_of_gathered_information') }}</strong>
                        </h4>
                        <!-- END Security of Gathered Information title -->

                        <!-- BEGIN Security of Gathered Information content -->
                        <p>{{ trans('privacy.security_of_gathered_information_content_1') }}</p>
                        <p>{{ trans('privacy.security_of_gathered_information_content_2') }}</p>
                        <p>{{ trans('privacy.security_of_gathered_information_content_3') }}</p>
                        <!-- END Security of Gathered Information content -->

                        <!-- BEGIN Accessing, changing and removing your personal information title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('privacy.access_change_remove_personal_information') }}</strong>
                        </h4>
                        <!-- END Accessing, changing and removing your personal information title -->

                        <!-- BEGIN Accessing, changing and removing your personal information content -->
                        <p>{{ trans('privacy.access_change_remove_personal_information_content_1') }}</p>
                        <p>{{ trans('privacy.access_change_remove_personal_information_content_2') }} <a href="mailto:support@nova-manager.com">support@nova-manager.com</a></p>
                        <!-- END Accessing, changing and removing your personal information content -->

                        <!-- BEGIN Cookies title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('privacy.cookies') }}</strong>
                        </h4>
                        <!-- END Cookies title -->

                        <!-- BEGIN Cookies content -->
                        <p>{{ trans('privacy.cookies_content') }}</p>
                        <!-- END Cookies content -->

                        <!-- BEGIN Disclosure of Information to Outside Parties title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('privacy.disclosure_of_information_to_outside_parties') }}</strong>
                        </h4>
                        <!-- END Disclosure of Information to Outside Parties title -->

                        <!-- BEGIN Disclosure of Information to Outside Parties content -->
                        <p>{{ trans('privacy.disclosure_of_information_to_outside_parties_content') }}</p>
                        <!-- END Disclosure of Information to Outside Parties content -->

                        <!-- BEGIN Business Transfers title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('privacy.business_transfers') }}</strong>
                        </h4>
                        <!-- END Business Transfers title -->

                        <!-- BEGIN Business Transfers content -->
                        <p>{{ trans('privacy.business_transfers_content') }}</p>
                        <!-- END Business Transfers content -->

                        <!-- BEGIN Privacy Policy Changes title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('privacy.privacy_policy_changes') }}</strong>
                        </h4>
                        <!-- END Privacy Policy Changes title -->

                        <!-- BEGIN Privacy Policy Changes content -->
                        <p>{{ trans('privacy.privacy_policy_changes_content') }}</p>
                        <!-- END Privacy Policy Changes content -->

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection