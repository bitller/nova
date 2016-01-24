<!-- BEGIN Edit client name modal -->
<div id="edit-client-name-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('clients.edit_client_name')])
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
                    <input id="client-name" type="text" placeholder="@{{ name }}" class="form-control" v-on="keyup: editClientName | key 13" v-model="client_name" />
                    <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.client_name">@{{ errors.client_name }}</span>
                </div>
                <!-- END Client name -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'editClientName'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit offer amount modal -->