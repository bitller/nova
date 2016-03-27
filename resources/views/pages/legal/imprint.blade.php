@extends('layout.welcome.index')
@section('content')

    <div class="fluid-container imprint-content">

        <!-- BEGIN Page short description -->
        <div class="row">
            <div class="container">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-2 imprint">
                    <h3 class="grey-text">{{ trans('welcome.imprint') }}</h3>
                </div>
            </div>
        </div>
        <!-- END Page short description -->

        <!-- BEGIN Divider -->
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div class="divider"></div>
            </div>
        </div>
        <!-- END Divider -->

        <!-- BEGIN Company legal details -->
        <div class="row product-of">
            <div class="container">

                <!-- BEGIN Icon -->
                <div class="col-xs-4 col-xs-offset-4 col-sm-3 col-sm-offset-5 col-md-3 col-md-offset-2">
                    <img class="img-responsive" src="/img/a-product-of.svg">
                </div>
                <!-- END Icon -->

                <!-- BEGIN Text -->
                <div class="col-xs-9 col-xs-offset-3 col-sm-4 col-sm-offset-4 col-sm-12 col-md-7 col-md-offset-0">

                    <!-- BEGIN Product owner -->
                    <h4 class="grey-text">{{ trans('welcome.a_product_of') }}:</h4>
                    <h5 class="light-grey-text">Bitller Societate cu Raspundere Limitata</h5>
                    <!-- END Product owner -->

                    <!-- BEGIN Fiscal code -->
                    <h4 class="grey-text">{{ trans('welcome.fiscal_code') }}:</h4>
                    <h5 class="light-grey-text">12345678</h5>
                    <!-- END Fiscal code -->

                    <!-- BEGIN VAT ID -->
                    <h4 class="grey-text">{{ trans('welcome.vat_id') }}:</h4>
                    <h5 class="light-grey-text">RO87654321</h5>
                    <!-- END VAT ID -->

                    <!-- BEGIN Registry of commerce number -->
                    <h4 class="grey-text">{{ trans('welcome.registry_of_commerce_number') }}:</h4>
                    <h5 class="light-grey-text">B44/2474/2004</h5>
                    <!-- END Registry of commerce number -->
                </div>
                <!-- END Text -->
            </div>
        </div>
        <!-- END Company legal details -->

        <!-- BEGIN Divider -->
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div class="divider"></div>
            </div>
        </div>
        <!-- END Divider -->

        <!-- BEGIN Contact emails -->
        <div class="row">
            <div class="container">

                <!-- BEGIN Icon -->
                <div class="col-xs-4 col-xs-offset-4 col-sm-3 col-sm-offset-5 col-md-3 col-md-offset-2">
                    <img class="img-responsive" src="/img/contact.svg">
                </div>
                <!-- END Icon -->

                <!-- BEGIN Text -->
                <div class="col-xs-9 col-xs-offset-3 col-sm-4 col-sm-offset-4 col-sm-12 col-md-7 col-md-offset-0">

                    <!-- BEGIN Suggestions and other ideas -->
                    <h4 class="grey-text">{{ trans('welcome.suggestions_and_other_ideas') }}:</h4>
                    <h5 class="light-grey-text"><a href="mailto:suggestions@nova-manager.com">suggestions@nova-manager.com</a></h5>
                    <!-- END Suggestions and other ideas -->

                    <!-- BEGIN Support -->
                    <h4 class="grey-text">{{ trans('welcome.support') }}</h4>
                    <h5 class="light-grey-text"><a href="mailto:support@nova-manager.com">support@nova-manager.com</a></h5>
                    <!-- END Support -->
                </div>
                <!-- END Text -->

            </div>
        </div>
        <!-- END Contact emails -->

        <!-- BEGIN Divider -->
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div class="divider"></div>
            </div>
        </div>
        <!-- END Divider -->

        <!-- BEGIN Contact phone number -->
        <div class="row">
            <div class="container">

                <!-- BEGIN Icon -->
                <div class="col-xs-4 col-xs-offset-4 col-sm-3 col-sm-offset-5 col-md-3 col-md-offset-2">
                    <img class="img-responsive" src="/img/phone.svg">
                </div>
                <!-- END Icon -->

                <!-- BEGIN Text -->
                <div class="col-xs-9 col-xs-offset-3 col-sm-4 col-sm-offset-4 col-sm-12 col-md-7 col-md-offset-0">
                    <h4 class="grey-text">{{ trans('welcome.phone') }}:</h4>
                    <h5 class="light-grey-text">+40 730167964</h5>
                </div>
                <!-- END Text -->

            </div>
        </div>
        <!-- END Contact phone number -->
    </div>

@endsection