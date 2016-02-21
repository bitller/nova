<!-- BEGIN Add targeted users modal -->
<div id="add-targeted-users-modal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <!-- BEGIN Modal header -->
            @include('includes.modals.partials.header', ['title' => trans('notifications.add_targeted_users')])
            <!-- END Modal header -->

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN Loader -->
                <div class="col-md-12 text-center" v-show="loading_targeted_users">
                    <span class="glyphicon glyphicon-refresh glyphicon-spin text-center"></span>
                </div>
                <!-- END Loader -->

                <!-- BEGIN Notification title -->
                <div v-show="!loading_targeted_users">
                    <label>{{ trans('notifications.selected_title') }}: @{{ current_title }}</label>
                </div>
                <!-- END Notification title -->

                <!-- BEGIN Targeted users groups -->
                <select class="form-control" v-show="!loading_targeted_users" v-model="target_users_group" name="choose-targeted-users-group" id="targeted-users-group">
                    <option selected disabled>{{ trans('notifications.select_targeted_users') }}</option>
                    <option v-repeat="target in targeted_users">@{{ target.name }}</option>
                </select>
                <!-- END Targeted users groups -->

            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', [
                'onClick' => 'addTargetedUsers',
                'loading' => 'loading_targeted_users_modal'
            ])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Add targeted users modal -->