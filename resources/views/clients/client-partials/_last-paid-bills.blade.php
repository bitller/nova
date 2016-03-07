<!-- BEGIN Last paid bills of this client divider -->
<div class="ff-primary-divider">
    <span>{{ trans('clients.last_paid_bills') }}</span>
</div>
<!-- END Last paid bills of this client divider -->

<!-- BEGIN Last paid bills of this client -->
<div class="ff-content">

    <!-- BEGIN Client does not have paid bills -->
    <div class="well custom-well" v-show="!last_paid_bills">
        <strong>{{ trans('clients.client_does_not_have_paid_bills') }}</strong>
    </div>
    <!-- END Client does not have paid bills -->

    <!-- BEGIN Panel -->
    <div class="panel panel-default" v-show="last_paid_bills">

        <!-- BEGIN Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <!-- BEGIN Number of products -->
                    <th class="text-center">
                        {{ trans('clients.number_of_products') }}
                    </th>
                    <!-- END Number of products -->

                    <!-- BEGIN Payment term -->
                    <th class="text-center">
                        {{ trans('clients.payment_term') }}
                    </th>
                    <!-- END Payment term -->

                    <!-- BEGIN Price -->
                    <th class="text-center">
                        {{ trans('bills.price') }}
                    </th>
                    <!-- END Price -->

                    <!-- BEGIN Order number -->
                    <th class="text-center">
                        {{ trans('clients.order_number') }}
                    </th>
                    <!-- END Order number -->

                    <!-- BEGIN Campaign -->
                    <th class="text-center">
                        {{ trans('bills.campaign') }}
                    </th>
                    <!-- END Campaign -->

                    <!-- BEGIN Access bill -->
                    <th class="text-center">
                        {{ trans('clients.access_bill') }}
                    </th>
                    <!-- END Access bill -->
                </tr>
            </thead>

            <tbody>
                <!-- BEGIN Bills -->
                <tr v-repeat="paid_bill in last_paid_bills">
                    <!-- BEGIN Number of products -->
                    <td class="text-center vert-align">
                        @{{ paid_bill.number_of_products }}
                    </td>
                    <!-- END Number of products -->

                    <!-- BEGIN Payment term -->
                    <td class="text-center vert-align">
                        @{{ paid_bill.payment_term }}
                    </td>
                    <!-- END Payment term -->

                    <!-- BEGIN Total -->
                    <td class="text-center vert-align">
                        @{{ paid_bill.total }}
                    </td>
                    <!-- END Total -->

                    <!-- BEGIN Campaign order -->
                    <td class="text-center vert-align">
                        @{{ paid_bill.campaign_order }}
                    </td>
                    <!-- END Campaign order -->

                    <!-- BEGIN Campaign year -->
                    <td class="text-center vert-align">
                        @{{ paid_bill.campaign_number }}/@{{ paid_bill.campaign_year }}
                    </td>
                    <!-- END Campaign year -->

                    <!-- BEGIN Access bills -->
                    <td class="text-center vert-align">
                        <a href="/bills/@{{ paid_bill.bill_id }}">
                            <button class="btn btn-default">
                                <span class="glyphicon glyphicon-arrow-right"></span>&nbsp;
                                {{ trans('clients.access_bill') }}
                            </button>
                        </a>
                    </td>
                    <!-- END Access bill -->
                </tr>
                <!-- END Bills -->
            </tbody>
        </table>
        <!-- END Table -->
    </div>
    <!-- END Panel -->
</div>
<!-- END Last paid bills of this client -->
