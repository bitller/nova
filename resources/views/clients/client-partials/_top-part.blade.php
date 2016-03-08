<!-- BEGIN Top part -->
<div class="ff-top-part">

    <!-- BEGIN Client name and client from -->
    <div class="ff-title-and-description">

        <!-- BEGIN Client name -->
        <div class="ff-title">
            @{{ name }}
        </div>
        <!-- END Client name -->

        <!-- BEGIN Client from -->
        <div class="ff-description">
            <strong>{{ trans('clients.client_since') }}: </strong>@{{ client.created_at }}
        </div>
        <!-- END Client from -->

    </div>
    <!-- END Client name and client from -->

    @include('includes.admin-center.buttons.more-options-dropdown', [
    'class' => 'pull-right',
    'text' => trans('common.options'),
    'items' => [
        [
            'url' => '#',
            'name' => trans('clients.edit_client_name'),
            'icon' => 'glyphicon-user',
            'data_toggle' => 'modal',
            'data_target' => '#edit-client-name-modal',
            'on_click' => 'resetEditClientNameModal'
        ],
        [
            'url' => '#',
            'name' => trans('clients.edit_client_email'),
            'icon' => 'glyphicon-envelope',
            'data_toggle' => 'modal',
            'data_target' => '#edit-client-email-modal',
            'on_click' => 'resetEditClientEmailModal'
        ],
        [
            'url' => '#',
            'name' => trans('clients.edit_client_phone_number'),
            'icon' => 'glyphicon-phone',
            'data_toggle' => 'modal',
            'data_target' => '#edit-client-phone-number-modal',
            'on_click' => 'resetEditClientPhoneNumberModal'
        ],
        [
            'url' => '#',
            'name' => trans('clients.delete_client'),
            'icon' => 'glyphicon-trash',
            'on_click' => 'deleteClient'
        ]
    ]
    ])
</div>
<!-- END Top part -->