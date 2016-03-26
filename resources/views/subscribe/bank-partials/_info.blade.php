<!-- BEGIN Bank info -->
<div class="col-sm-12 col-md-12 col-lg-12">
    <div class="alert alert-info">
        Aceasta metoda presupune deplasarea la banca pentru efectuarea platii in contul nostru. A fost special creata pentru persoanele care nu au,
        sau nu doresc sa plateasca cu cardul online.
    </div>

    <!-- BEGIN Steps -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-sm-offset-0 col-md-offset-3 col-lg-offset-3">

        <!-- BEGIN Step 1 -->
        <div class="grey-text">

            <!-- BEGIN Step number -->
            <h4 class="underlined"><strong>{{ trans('subscribe.step_1') }}</strong></h4>
            <!-- END Step number -->

            <!-- BEGIN Step description -->
            <div class="row">

                <div class="col-lg-12">{{ trans('subscribe.step_1_description') }}</div>

                <div class="col-lg-12 payment-intervals">

                    <!-- BEGIN One month interval -->
                    <div class="col-lg-3 col-lg-offset-2 text-center">
                        <div class="payment-interval selected-interval">
                            <h4><strong>19.99</strong></h4> ron/luna
                        </div>
                    </div>
                    <!-- END One month interval -->

                    <!-- BEGIN Three months interval -->
                    <div class="col-lg-3 col-lg-offset-2 text-center">
                        <div class="payment-interval"><h4>19.99</h4> ron/luna</div>
                    </div>
                    <!-- END Three months interval -->

                    <!-- BEGIN Selected plan -->
                    <div class="row">
                        <div class="col-lg-12 selected-interval-info">
                            <div>
                                <strong>Ai selectat intervalul de plata lunar.</strong>
                            </div>
                        </div>
                    </div>
                    <!-- END Selected plan -->

                </div>
            </div>
            <!-- END Step description -->

        </div>
        <!-- END Step 1 -->

        <div class="divider"></div>

        <!-- BEGIN Step 2 -->
        <div class="grey-text">

            <!-- BEGIN Step number -->
            <h4 class="underlined"><strong>{{ trans('subscribe.step_2') }}</strong></h4>
            <!-- END Step number -->

            <!-- BEGIN Step description -->
            <div>
                <div>{{ trans('subscribe.step_2_description') }}</div>

                <!-- BEGIN User does not have printer help link -->
                <div class="user-does-not-have-printer">
                    <strong>
                        <a href="#" data-target="#company-details-modal" data-toggle="modal">{{ trans('subscribe.view_company_details') }}</a>
                    </strong>
                </div>
                <!-- END User does not have printer help link -->

            </div>
            <!-- END Step description -->

        </div>
        <!-- END Step 2 -->

        <div class="divider"></div>

        <!-- BEGIN Step 3 -->
        <div class="grey-text">

            <!-- BEGIN Step number -->
            <h4 class="underlined"><strong>{{ trans('subscribe.step_3') }}</strong></h4>
            <!-- END Step number -->

            <!-- BEGIN Step description -->
            <div>
                <div>{{ trans('subscribe.step_3_description') }}</div>
                <div><strong>{{ trans('subscribe.step_3_description_two') }}</strong></div>
            </div>
            <!-- END Step description -->
        </div>
        <!-- END Step 3 -->

        <div class="divider"></div>

        <!-- BEGIN Step 4 -->
        <div class="grey-text">

            <!-- BEGIN Step number -->
            <h4 class="underlined"><strong>{{ trans('subscribe.step_4') }}</strong></h4>
            <!-- END Step number -->

            <!-- BEGIN Step description -->
            <div>
                <div>{{ trans('subscribe.step_4_description') }}</div>
                <div class="text-danger"><strong>{{ trans('subscribe.abuse_warning') }}</strong></div>

                <br>

                <!-- BEGIN Start subscription button -->
                <div class="btn btn-block btn-primary" data-target="#confirm-start-subscription-modal" data-toggle="modal">
                    {{ trans('subscribe.payment_done_and_activate_subscription') }}
                </div>
                <!-- END Start subscription button -->

            </div>
            <!-- END Step description -->

        </div>
        <!-- END Step 4 -->

    </div>
    <!-- END Steps -->

    @include('modals.subscribe.bank._company-details')
    @include('modals.subscribe.bank._confirm-start-subscription')

</div>
<!-- END Bank info -->