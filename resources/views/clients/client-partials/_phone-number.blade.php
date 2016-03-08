<!-- BEGIN Client phone number -->
<span>

    <!-- BEGIN Phone number translation -->
    <span>
        {{ trans('clients.phone_number') }}:
    </span>
    <!-- END Phone number translation -->

    <!-- BEGIN Phone number value -->
    <span v-show="phone_number" class="pointer underline" v-on="click: resetEditClientPhoneNumberModal" data-target="#edit-client-phone-number-modal" data-toggle="modal">
        @{{ phone_number }}
    </span>
    <!-- END Phone number value -->

    <!-- BEGIN Set phone number -->
    <span v-show="!phone_number" class="pointer underline" v-on="click: resetEditClientPhoneNumberModal" data-target="#edit-client-phone-number-modal" data-toggle="modal">
        {{ trans('clients.set_now') }}
    </span>
    <!-- END Set phone number -->

    <span class="spacer">-</span>

</span>
<!-- END Client phone number -->