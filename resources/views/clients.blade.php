@extends('layout')
@section('content')

    @include('includes.ajax-translations.clients')
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
                <span class="my-clients-title">{{ trans('clients.my_clients') }} <span class="badge">@{{ clients.total }}</span></span>
                <button type="button" class="btn btn-primary pull-right" v-on="click: createClient()">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('clients.add') }}
                </button>
            </div>

            <div class="alert alert-info" v-show="!clients.total">
                {{ trans('clients.no_clients') }}
            </div>

            <!-- BEGIN Clients table-->
            <div class="panel panel-default">
                <table class="table table-hover table-bordered" v-show="clients.total">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('clients.name') }}</th>
                            <th class="text-center">{{ trans('clients.phone_number') }}</th>
                            <th class="text-center">{{ trans('clients.number_of_orders') }}</th>
                            <th class="text-center">{{ trans('clients.client_from') }}</th>
                            <th class="text-center">{{ trans('common.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-repeat="client in clients.data">
                            <td class="text-center vert-align"><a href="/clients/@{{ client.id }}">@{{ client.name }}</a></td>
                            <td class="text-center vert-align">@{{ client.phone_number }}</td>
                            <td class="text-center vert-align">4</td>
                            <td class="text-center vert-align">@{{ client.created_at }}</td>
                            <td class="text-center vert-align"><button class="btn btn-danger" v-on="click: deleteClient(client.id, clients.current_page, clients.to-clients.from)"><span class="glyphicon glyphicon-trash"></span> {{ trans('common.delete') }}</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
    <script src="/js/header-search.js"></script>
    <script src="/js/clients.js"></script>
@endsection