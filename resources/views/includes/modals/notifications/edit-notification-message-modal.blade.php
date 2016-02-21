<!-- BEGIN Edit notification message modal -->
<div id="edit-notification-message-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('notifications.edit_notification_message')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN New notification message -->
                <div class="form-group">
                    <label for="new-notification-message">{{ trans('notifications.new_notification_message') }}</label>
                    <input v-model="new_notification_message" v-on="keyup:editNotificationMessage | key 13" id="new-notification-message" type="text" class="form-control" placeholder="@{{ current_message }}" />
                </div>
                <!-- END New notification message -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', [
                'onClick' => 'editNotificationMessage',
                'loading' => 'loading_message_modal'
            ])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit notification message modal -->