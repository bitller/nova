@extends('layout')
@section('content')
    <div id="clients" loading="{{ trans('common.loading') }}"
         confirm="{{ trans('common.confirm') }}"
         confirm-message="{{ trans('clients.all_bills_will_be_deleted') }}"
         confirm-delete="{{ trans('common.confirm_delete') }}"
         cancel="{{ trans('common.cancel') }}"
         add-client="{{ trans('clients.add') }}"
         client-name="{{ trans('clients.client_name') }}"
         client-name-required="{{ trans('clients.client_name_required') }}"
         client-phone-number="{{ trans('clients.client_phone_number') }}"
         phone-is-optional="{{ trans('clients.phone_number_optional') }}"
         insert-client-name="{{ trans('clients.insert_client_name') }}"
         ok-button="{{ trans('common.ok') }}" continue="{{ trans('common.continue') }}">

        <div v-show="loaded">

            <div class="add-client-button">
                <span class="my-clients-title">{{ trans('clients.my_clients') }} (@{{ clients.total }})</span>
                <button class="btn btn-default" data-toggle="popover" data-trigger="focus" data-content="{{ trans('clients.page_help') }}">{{ trans('common.page_details') }}</button>
                <button type="button" class="btn btn-primary pull-right" v-on="click: createClient()">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('clients.add') }}
                </button>
            </div>

            <!-- BEGIN Clients table-->
            <table class="table table-hover" v-show="clients.total">
                <thead>
                    <tr>
                        <th>{{ trans('clients.name') }}</th>
                        <th>{{ trans('clients.phone_number') }}</th>
                        <th>{{ trans('clients.number_of_orders') }}</th>
                        <th>{{ trans('clients.client_from') }}</th>
                        <th>{{ trans('common.delete') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-repeat="client in clients.data">
                        <td class="vert-align"><a href="/clients/@{{ client.id }}">@{{ client.name }}</a></td>
                        <td class="vert-align">@{{ client.phone_number }}</td>
                        <td class="vert-align">4</td>
                        <td class="vert-align">@{{ client.created_at }}</td>
                        <td class="vert-align"><button class="btn btn-danger" v-on="click: deleteClient(client.id, clients.current_page, clients.to-clients.from)"><span class="glyphicon glyphicon-trash"></span> {{ trans('common.delete') }}</button></td>
                    </tr>
                </tbody>
            </table>
            <!-- END Clients table -->

            <!-- BEGIN Pagination links -->
            <ul class="pager" v-show="clients.total > clients.per_page">
                <li v-class="disabled : !clients.prev_page_url"><a href="#" v-on="click: paginate(clients.prev_page_url)">{{ trans('common.previous') }}</a></li>
                <li v-class="disabled : !clients.next_page_url"><a href="#" v-on="click: paginate(clients.next_page_url)">{{ trans('common.next') }}</a></li>
            </ul>
            <!-- END Pagination links -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/clients.js"></script>
@endsection