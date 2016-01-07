<!-- BEGIN User password -->
<div class="form-group has-feedback" v-class="has-error : errors.user_password">
    <label for="user-password">{{ trans('offers.your_password') }}:</label>
    <input id="user-password" type="password" class="form-control" v-on="keyup: {{ $onEnter }} | key 13" v-model="user_password" />
    <i class="glyphicon glyphicon-lock form-control-feedback icon-color"></i>
    <span class="text-danger" v-show="errors.user_password">@{{ errors.user_password }}</span>
</div>
<!-- END User password -->