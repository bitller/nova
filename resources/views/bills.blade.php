@extends('layout.index')
@section('content')
    <div id="bills">

        @include('includes.ajax-translations.bills')

        <div id="table" v-show="loaded">

            <!-- BEGIN Add bill button -->
            <div class="add-bill-button">
                <span class="my-bills-title">{{ trans('bills.my_bills') }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('bills.number_of_bills') }}">@{{ bills.total }}</span></span>
                <button type="button" data-toggle="modal" data-target="#create-bill-modal" v-on="click: resetCreateBillModal()" class="btn btn-primary pull-right">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('bills.create') }}
                </button>
            </div>
            <!-- END Add bill button -->

            <!-- BEGIN No bills info -->
            <div class="alert alert-info no-bills-info" v-show="!bills.total">
                {{ trans('bills.no_bills') }}
            </div>
            <!-- END No bills info -->

            <!-- BEGIN Bills table-->
            <div class="panel panel-default" v-show="bills.total">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <!-- BEGIN Client -->
                    <th class="text-center">
                        <span data-toggle="tooltip" data-placement="top" title="{{ trans('bills.client_tooltip') }}">
                            <span class="glyphicon glyphicon-user icon-color"></span>&nbsp;
                            {{ trans('bills.client') }}
                        </span>
                    </th>
                    <!-- END Client -->

                    <!-- BEGIN Number of products -->
                    <th class="text-center">
                        <span data-toggle="tooltip" data-placement="top" title="{{ trans('bills.number_of_products_tooltip') }}">
                            <span class="glyphicon glyphicon-th icon-color"></span>&nbsp;
                            {{ trans('bills.number_of_products') }}
                        </span>
                    </th>
                    <!-- END Number of products -->

                    <!-- BEGIN Price -->
                    <th class="text-center">
                        <span data-toggle="tooltip" data-placement="top" title="{{ trans('bills.price_tooltip') }}">
                        <span class="glyphicon glyphicon-euro icon-color"></span>&nbsp;
                            {{ trans('bills.price') }}
                        </span>
                    </th>
                    <!-- END Price -->

                    <!-- BEGIN Campaign order -->
                    <th class="text-center">
                        <span data-toggle="tooltip" data-placement="top" title="{{ trans('bills.campaign_order_tooltip') }}">
                            <span class="glyphicon glyphicon-tag icon-color"></span>&nbsp; {{ trans('bills.campaign_order') }}
                        </span>
                    </th>
                    <!-- END Campaign order -->

                    <!-- BEGIN Campaign -->
                    <th class="text-center">
                        <span data-toggle="tooltip" data-placement="top" title="{{ trans('bills.campaign_tooltip') }}">
                            <span class="glyphicon glyphicon-tags icon-color"></span>&nbsp; {{ trans('bills.campaign') }}
                        </span>
                    </th>
                    <!-- END Campaign -->

                    <!-- BEGIN Payment term -->
                    <th class="text-center">
                        <span data-toggle="tooltip" data-placement="top" title="{{ trans('bills.payment_term_tooltip') }}">
                            <span class="glyphicon glyphicon-calendar icon-color"></span>&nbsp; {{ trans('bill.payment_term') }}
                        </span>
                    </th>
                    <!-- END Payment term -->

                    <!-- BEGIN Delete bill -->
                    <th class="text-center">
                        <span data-toggle="tooltip" data-placement="top" title="{{ trans('bills.delete_bill_tooltip') }}">
                            <span class="glyphicon glyphicon-trash icon-color"></span>&nbsp; {{ trans('common.delete') }}
                        </span>
                    </th>
                    <!-- END Delete bill -->

                </tr>
                </thead>
                <tbody>
                <tr v-repeat="bill in bills.data">

                    <!-- BEGIN Client name -->
                    <td class="text-center vert-align">
                        <a href="/bills/@{{bill.id}}">@{{ bill.client_name }}</a>
                    </td>
                    <!-- END Client name -->

                    <!-- BEGIN Number of products -->
                    <td class="text-center vert-align">
                        <span v-show="bill.number_of_products > 0">@{{ bill.number_of_products }}</span>
                        <span v-show="bill.number_of_products < 1">0</span>
                    </td>
                    <!-- END Number of products -->

                    <!-- BEGIN Price -->
                    <td class="text-center vert-align">
                        <span v-show="bill.final_price > 0">@{{ bill.final_price }} ron</span>
                        <span v-show="bill.final_price < 1">0 ron</span>
                    </td>
                    <!-- END Price -->

                    <!-- BEGIN Campaign order -->
                    <td class="text-center vert-align">
                        @{{ bill.campaign_order }}
                    </td>
                    <!-- END Campaign order -->

                    <!-- BEGIN Campaign -->
                    <td class="text-center vert-align">
                        <a href="/statistics/campaign/@{{ bill.campaign_number }}/@{{ bill.campaign_year }}">
                            @{{ bill.campaign_number }}/@{{ bill.campaign_year }}
                        </a>
                    </td>
                    <!-- END Campaign -->

                    <!-- BEGIN Payment term -->
                    <td class="text-center vert-align">
                        <span v-show="bill.payment_term == '0000-00-00'">{{ trans('bill.not_set') }}</span>
                        <span v-show="bill.payment_term != '0000-00-00'">@{{ bill.payment_term }}</span>
                    </td>
                    <!-- END Payment term -->

                    <td class="text-center vert-align"><button class="btn btn-default" v-on="click: deleteBill(bill.id, bills.current_page, bills.to-bills.from,'{{ trans('common.loading') }}')"><span class="glyphicon glyphicon-trash"></span> {{ trans('common.delete') }}</button></td>
                </tr>
                </tbody>
            </table>
            </div>
            <!-- END Bills table -->

            <!-- BEGIN Pagination links -->
            <ul class="pager" v-show="bills.total > bills.per_page">
                <li v-class="disabled : !bills.prev_page_url"><a href="#" v-on="click: paginate(bills.prev_page_url)">{{ trans('common.previous') }}</a></li>
                <li v-class="disabled : !bills.next_page_url"><a href="#" v-on="click: paginate(bills.next_page_url)">{{ trans('common.next') }}</a></li>
            </ul>
            <!-- END Pagination links -->

        </div>

        @include('includes.modals.create-bill')

    </div>
@endsection

@section('scripts')
    <script src="/js/bills.js"></script>
@endsection