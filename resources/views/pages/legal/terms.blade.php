@extends('layout.welcome.index')
@section('content')
    <div class="container-fluid terms-content">

        <!-- BEGIN Page short description -->
        <div class="row">
            <div class="container">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-12 col-md-offset-0 col-lg-12 col-lg-offset-0 terms">
                    <h3 class="grey-text">{{ trans('terms.terms_and_conditions') }}</h3>
                </div>
            </div>
        </div>
        <!-- END Page short description -->

        <div class="row">
            <div class="container">
                <div class="col-md-12 col-lg-12">
                    <div class="well custom-well">

                        <!-- BEGIN Revision date -->
                        <h4 class="revision">
                            <span class="label label-success">{{ trans('welcome.revision_date') }}: 22.04.2016</span>
                        </h4>
                        <!-- END Revision date -->

                        <!-- BEGIN Head content -->
                        <p>{{ trans('terms.head_content_1') }}</p>
                        <p>{{ trans('terms.head_content_2') }}</p>
                        <p>{{ trans('terms.head_content_3') }}</p>
                        <!-- END Head content -->

                        <!-- BEGIN Payment and renewal title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.payment_and_renewal') }}</strong>
                        </h4>
                        <!-- END Payment and renewal title -->

                        <!-- BEGIN Payment and renewal content -->
                        <ul>
                            <li>
                                <strong>{{ trans('terms.payment_and_renewal_content_1') }}</strong>
                                <p>{{ trans('terms.payment_and_renewal_content_2') }}</p>
                            </li>
                            <li>
                                <strong>{{ trans('terms.payment_and_renewal_content_3') }}</strong>
                                <p>{{ trans('terms.payment_and_renewal_content_4') }}</p>
                            </li>
                        </ul>
                        <!-- END Payment and renewal content -->

                        <!-- BEGIN Refund policy title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.refund_policy') }}</strong>
                        </h4>
                        <!-- END Refund policy title -->

                        <!-- BEGIN Refund policy content -->
                        <p>{{ trans('terms.refund_policy_content_1') }}</p>
                        <p>{{ trans('terms.refund_policy_content_2') }}</p>
                        <!-- END Refund policy content -->

                        <!-- BEGIN Responsibility of Website Visitors title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.responsibility_of_visitors') }}</strong>
                        </h4>
                        <!-- END Responsibility of Website Visitors title -->

                        <!-- BEGIN Responsibility of Website Visitors content -->
                        <p>{{ trans('terms.responsibility_of_visitors_content') }}</p>
                        <!-- END Responsibility of Website Visitors content -->

                        <!-- BEGIN Copyright Infringement title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.copyright_infringement') }}</strong>
                        </h4>
                        <!-- END Copyright Infringement title -->

                        <!-- BEGIN Copyright Infringement content -->
                        <p>{{ trans('terms.copyright_infringement_content') }}</p>
                        <!-- END Copyright Infringement content -->

                        <!-- BEGIN Changes title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.changes') }}</strong>
                        </h4>
                        <!-- END Changes title -->

                        <!-- BEGIN Changes content -->
                        <p>{{ trans('terms.changes_content') }}</p>
                        <!-- END Changes content -->

                        <!-- BEGIN Termination title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.termination') }}</strong>
                        </h4>
                        <!-- END Termination title -->

                        <!-- BEGIN Termination content -->
                        <p>{{ trans('terms.termination_content') }}</p>
                        <!-- END Termination content -->

                        <!-- BEGIN Disclaimer of Warranties title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.termination') }}</strong>
                        </h4>
                        <!-- END Disclaimer of Warranties title -->

                        <!-- BEGIN Disclaimer of Warranties content -->
                        <p>{{ trans('terms.disclaimer_of_warranties_content') }}</p>
                        <!-- END Disclaimer of Warranties content -->

                        <!-- BEGIN Limitation of Liability title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.limitation_of_liability') }}</strong>
                        </h4>
                        <!-- END Limitation of Liability title -->

                        <!-- BEGIN Limitation of Liability content -->
                        <p>{{ trans('terms.limitation_of_liability_content') }}</p>
                        <!-- END Limitation of Liability content -->

                        <!-- BEGIN General Representation and Warranty title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.general_representation') }}</strong>
                        </h4>
                        <!-- END General Representation and Warranty title -->

                        <!-- BEGIN General Representation and Warranty content -->
                        <p>{{ trans('terms.general_representation_content') }}</p>
                        <!-- END General Representation and Warranty content -->

                        <!-- BEGIN Indemnification title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.indemnification') }}</strong>
                        </h4>
                        <!-- END Indemnification title -->

                        <!-- BEGIN Indemnification content -->
                        <p>{{ trans('terms.indemnification_content') }}</p>
                        <!-- END Indemnification content -->

                        <!-- BEGIN Miscellaneous title -->
                        <h4 class="top-bottom-space">
                            <strong>{{ trans('terms.miscellaneous') }}</strong>
                        </h4>
                        <!-- END Miscellaneous title -->

                        <!-- BEGIN Miscellaneous content -->
                        <p>{{ trans('terms.miscellaneous_content') }}</p>
                        <!-- END Miscellaneous content -->

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection