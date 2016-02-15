<!-- BEGIN Compare campaigns modal -->
<div id="compare-campaigns-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('statistics.choose_campaign_to_compare_with')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Loader -->
                <div class="col-md-12 text-center" v-show="loading_modal_data">
                    <span class="glyphicon glyphicon-refresh glyphicon-spin text-center"></span>
                </div>
                <!-- END Loader -->

                <!-- BEGIN Choose campaign year -->
                <div class="form-group" v-show="!loading_modal_data" year-selected="selected_year">
                    <label for="years">{{ trans('statistics.select_campaign_year') }}</label>
                    <select class="form-control" id="years" v-model="selected_year">
                        <option label=" "></option>
                        <option v-repeat="year in years" value="@{{ year.year }}" v-on="click: getCampaignNumbers">@{{ year.year }}</option>
                    </select>
                </div>
                <!-- END Choose campaign year -->

                <!-- BEGIN Choose campaign number -->
                <div class="form-group" v-show="!loading_modal_data && numbers_loaded">
                    <label for="numbers">{{ trans('statistics.select_campaign_number') }}</label>
                    <select class="form-control" id="numbers" v-model="selected_number">
                        <option v-repeat="number in numbers" value="@{{ number.number }}" v-on="click: compareCampaigns">@{{ number.number }}</option>
                    </select>
                </div>
                <!-- END Choose campaign number -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'isOfferEnabled'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Compare campaigns modal -->