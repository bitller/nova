<!-- BEGIN Edit client phone number modal -->
<div id="edit-client-phone-number-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('clients.edit_client_phone_number')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Client phone number -->
                <div class="form-group has-feedback" v-class="has-error : errors.client_phone_number">
                    <label for="client-phone-number">
                        {{ trans('clients.client_phone_number') }}
                        <span class="badge" data-toggle="tooltip" title="{{ trans('clients.client_phone_number_description') }}">?</span>
                    </label>
                    <input id="client-phone-number" type="text" placeholder="@{{ phone_number }}" class="form-control" v-on="keyup: editClientPhoneNumber | key 13" v-model="client_phone_number" />
                    <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.client_phone_number">@{{ errors.client_phone_number }}</span>
                </div>
                <!-- END Client phone number -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'editClientPhoneNumber'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit client phone number modal -->