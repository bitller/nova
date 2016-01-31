<!-- BEGIN Create bill modal -->
<div id="create-bill-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" v-attr="disabled : loading">&times;</button>
                <h4 class="modal-title">{{ trans('bills.create') }}</h4>
            </div>
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                <!-- BEGIN Error message -->
                <div class="col-md-12" v-show="error">
                    <div class="alert alert-danger">@{{ error }}</div>
                </div>
                <!-- END Error message -->

                <!-- BEGIN Client name -->
                <div role="form" class="col-md-12">
                    <div class="form-group has-feedback client-name">
                        <label for="client-name">{{ trans('bills.client_name') }}:</label>
                        <input v-on="keyup:createBill | key 13" type="text" class="twitter-typeahead form-control" id="client-name" v-model="clientName">
                        <i class="glyphicon glyphicon-refresh glyphicon-spin form-control-feedback add-product-to-bill-loader"></i>
                    </div>
                </div>
                <!-- END Client name -->

                <!-- BEGIN Use current campaign -->
                <div class="checkbox col-md-12">
                    <label><input type="checkbox" checked="use_current_campaign" v-model="use_current_campaign" />{{ trans('bills.use_current_campaign', ['current_campaign_number' => \App\Helpers\Campaigns::current()->number, 'current_campaign_year' => \App\Helpers\Campaigns::current()->year]) }}</label>
                    <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('bills.use_current_campaign_description') }}">?</span>
                </div>
                <!-- END Use current campaign -->

                <!-- BEGIN Choose another campaign -->
                <div v-show="!use_current_campaign" class="col-md-12">
                    <div class="form-group col-md-4">
                        <label for="campaign-year">{{ trans('bills.campaign_year') }}</label>
                        <select class="form-control" id="campaign-year" v-model="campaign_year">
                            <option selected="selected">2016</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="campaign-number">{{ trans('bills.campaign_number') }}</label>
                        <select class="form-control" id="campaign-number" v-model="campaign_number">
                            <option selected="selected">1</option>
                            @for ($i = 2; $i <= 17; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <!-- END Choose another campaign -->

            </div>
            <!-- END Modal body -->

            <!-- BEGIN Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" v-attr="disabled: loading" v-on="click: resetCreateBillModal()">{{ trans('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" v-attr="disabled: loading" v-on="click: createBill()">
                    <span v-show="loading" class="glyphicon glyphicon-refresh glyphicon-spin"></span>
                    <span v-show="!loading">{{ trans('bills.create') }}</span>
                </button>
            </div>
            <!-- END Modal footer -->

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Create bill modal -->