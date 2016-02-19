<!-- BEGIN Create new notification modal -->
<div id="create-new-notification-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('notifications.create_new_notification')])
                    <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Notification type -->
                <div class="form-group" v-class="has-error : errors.type">
                    <label for="notification-type">{{ trans('notifications.type') }}:</label>
                    <select v-model="type" id="notification-type" class="form-control">
                        <option selected disabled>{{ trans('notifications.choose_notification_type') }}</option>
                        <option v-repeat="notification_type in types">@{{ notification_type.type }}</option>
                    </select>
                    <span class="text-danger" v-show="errors.type">@{{ errors.type }}</span>
                </div>
                <!-- END Notification type -->

                <!-- BEGIN Notification title -->
                <div class="form-group" v-class="has-error : errors.title">
                    <label for="notification-title">{{ trans('notifications.title') }}:</label>
                    <input v-model="title" v-on="keyup:createNewNotification | key 13" id="notification-title" type="text" class="form-control" placeholder="{{ trans('notifications.title') }}" />
                    <span class="text-danger" v-show="errors.title">@{{ errors.title }}</span>
                </div>
                <!-- END Notification title -->

                <!-- BEGIN Notification message -->
                <div class="form-group" v-class="has-error : errors.message">
                    <label for="notification-message">{{ trans('notifications.message') }}:</label>
                    <input v-model="message" v-on="keyup:createNewNotification | key 13" id="notification-message" type="text" class="form-control" placeholder="{{ trans('notifications.message') }}" />
                    <span class="text-danger" v-show="errors.message">@{{ errors.message }}</span>
                </div>
                <!-- END Notification message -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', [
                'onClick' => 'createNewNotification',
                'loading' => 'loading_notifications_modal'
            ])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Create new notification modal -->