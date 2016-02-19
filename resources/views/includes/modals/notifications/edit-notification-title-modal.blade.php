<!-- BEGIN Edit notification title modal -->
<div id="edit-notification-title-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('notifications.edit_notification_title')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN New notification title -->
                <div class="form-group">
                    <label for="new-notification-title">{{ trans('notifications.new_notification_title') }}</label>
                    <input v-model="new_notification_title" v-on="keyup: editNotificationTitle() | key 13" id="new-notification-title" type="text" class="form-control" placeholder="@{{ current_title }}" />
                </div>
                <!-- END New notification title -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', [
                'onClick' => 'editNotificationTitle()',
                'loading' => 'loading_title_modal'
            ])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Edit notification title modal -->