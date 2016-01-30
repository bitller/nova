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

                {{--<!-- BEGIN Campaign order number -->--}}
                {{--<div role="form" class="col-md-12">--}}
                    {{--<div class="form-group has-feedback">--}}
                        {{--<label for="campaign-order-number">{{ trans('bills.campaign_order_number') }} &nbsp; <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('bills.campaign_order_number_description') }}">?</span> :</label>--}}
                        {{--<input v-on="keyup:createBill | ley 13" type="text" id="campaign-order-number" class="form-control" v-model="campaign_order" placeholder="1">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- END Campaign order number -->--}}

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
                            <option>2015</option>
                            <option>2016</option>
                            <option>2017</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="campaign-number">{{ trans('bills.campaign_number') }}</label>
                        <select class="form-control" id="campaign-number" v-model="campaign_number">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="campaign-order">{{ trans('bills.campaign_order') }}</label>
                        <select class="form-control" id="campaign-order" v-model="campaign_order">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
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