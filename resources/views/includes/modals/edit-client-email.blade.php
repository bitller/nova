<!-- BEGIN Edit client email modal -->
<div id="edit-client-email-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('clients.edit_client_email')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Client email -->
                <div class="form-group has-feedback" v-class="has-error : errors.client_email">
                    <label for="client-email">
                        {{ trans('clients.client_email') }}
                        <span class="badge" data-toggle="tooltip" title="{{ trans('clients.client_email_description') }}">?</span>
                    </label>
                    <input id="client-email" type="text" placeholder="@{{ email }}" class="form-control" v-on="keyup: editClientEmail | key 13" v-model="client_email" />
                    <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.client_email">@{{ errors.client_email }}</span>
                </div>
                <!-- END Client email -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'editClientEmail'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit offer amount modal -->