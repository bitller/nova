<!-- BEGIN Client email -->
<span>
    <!-- BEGIN Email translation -->
    <span>
        {{ trans('clients.email') }}:
    </span>
    <!-- END Email translation -->

    <!-- BEGIN Email value -->
    <span v-show="email" class="pointer underline" v-on="click: resetEditClientEmailModal" data-target="#edit-client-email-modal" data-toggle="modal">
        @{{ email }}
    </span>
    <!-- END Email value -->

    <!-- BEGIN Not set email -->
    <span v-show="!email" class="pointer underline" v-on="click: resetEditClientEmailModal" data-target="#edit-client-email-modal" data-toggle="modal">
        {{ trans('clients.set_now') }}
    </span>
    <!-- END Not set email -->

    <span class="spacer">-</span>
</span>
<!-- END Client email -->