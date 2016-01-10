<!-- BEGIN Create new user modal -->
<div id="create-new-user-modal" data-backdrop="static" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            @include('includes.modals.partials.header', ['title' => trans('users_manager.create_new_user')])

            <!-- BEGIN Modal body -->
            <div class="modal-body col-md-12">

                @include('includes.modals.partials.error')

                <!-- BEGIN New user email -->
                <div class="form-group has-feedback" v-class="has-error : errors.new_user_email">
                    <label for="new-user-email">{{ trans('users_manager.new_user_email') }}:</label>
                    <input id="new-user-email" type="text" class="form-control" v-on="keyup: createNewUser | key 13" v-model="new_user_email" />
                    <i class="glyphicon glyphicon-user form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.new_user_email">@{{ errors.new_user_email }}</span>
                </div>
                <!-- END New user email -->

                <!-- BEGIN New user password -->
                <div class="form-group has-feedback" v-class="has-error : errors.new_user_password">
                    <label for="new-user-password">{{ trans('users_manager.new_user_password') }}:</label>
                    <input id="new-user-password" type="password" class="form-control" v-on="keyup: createNewUser | key 13" v-model="new_user_password" />
                    <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.new_user_password">@{{ errors.new_user_password }}</span>
                </div>
                <!-- END New user password -->

                <!-- BEGIN New user password confirmation -->
                <div class="form-group has-feedback" v-class="has-error : errors.new_user_password_confirmation">
                    <label for="new-user-password-confirmation">{{ trans('users_manager.new_user_password_confirmation') }}:</label>
                    <input id="new-user-password-confirmation" type="password" class="form-control" v-on="keyup: createNewUser | key 13" v-model="new_user_password_confirmation" />
                    <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
                    <span class="text-danger" v-show="errors.new_user_password_confirmation">@{{ errors.new_user_password_confirmation }}</span>
                </div>
                <!-- END New user password confirmation -->

                <!-- BEGIN Make special user -->
                <div class="checkbox">
                    <label><input type="checkbox" v-model="special_user" />{{ trans('users_manager.make_special_user') }}</label>
                    <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('users_manager.make_special_user_info') }}">?</span>
                </div>
                <!-- END Make special user -->

                <div class="divider"></div>

                @include('includes.modals.partials.user-password-input', ['onEnter' => 'createNewUser'])
            </div>
            <!-- END Modal body -->

            @include('includes.modals.partials.footer', ['onClick' => 'createNewUser'])

        </div>
        <!-- END Modal content -->
    </div>
</div>
<!-- END Create new user modal -->