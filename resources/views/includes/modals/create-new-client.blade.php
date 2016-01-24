<!-- BEGIN Create new client modal -->
<div id="create-new-client-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('clients.add')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Client name -->
                <div class="form-group has-feedback" v-class="has-error : errors.client_name">
                    <label for="client-name">
                        {{ trans('clients.client_name') }}
                        <span class="badge" data-toggle="tooltip" title="{{ trans('clients.client_name_description') }}">?</span>
                    </label>
                    <input id="client-name" type="text" class="form-control" v-on="keyup: createClient | key 13" v-model="client_name" />
                    <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.client_name">@{{ errors.client_name }}</span>
                </div>
                <!-- END Client name -->

                <!-- BEGIN Client email -->
                <div class="form-group has-feedback" v-class="has-error : errors.client_email">
                    <label for="client-email">
                        {{ trans('clients.client_email') }}
                        <span class="badge" data-toggle="tooltip" title="{{ trans('clients.client_email_description') }}">?</span>
                    </label>
                    <input id="client-email" type="text" class="form-control" v-on="keyup: createClient | key 13" v-model="client_email" />
                    <i class="glyphicon glyphicon-envelope form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.client_email">@{{ errors.client_email }}</span>
                </div>
                <!-- END Client email -->

                <!-- BEGIN Client phone number -->
                <div class="form-group has-feedback" v-class="has-error : errors.client_phone_number">
                    <label for="client-phone-number">
                        {{ trans('clients.client_phone_number') }}
                        <span class="badge" data-toggle="tooltip" title="{{ trans('clients.client_phone_number_description') }}">?</span>
                    </label>
                    <input id="client-phone-number" type="text" class="form-control" v-on="keyup: createClient | key 13" v-model="client_phone_number" />
                    <i class="glyphicon glyphicon-phone form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.client_phone_number">@{{ errors.client_phone_number }}</span>
                </div>
                <!-- END Client phone number -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'createClient'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit offer amount modal -->