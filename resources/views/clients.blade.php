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
                <span class="my-clients-title">{{ trans('clients.my_clients') }} <span class="badge" data-toggle="tooltip" data-placement="right" title="{{ trans('clients.number_of_clients') }}">@{{ clients.total }}</span></span>
                <button v-on="click: resetCreateClientModal" type="button" class="btn btn-primary pull-right" data-target="#create-new-client-modal" data-toggle="modal">
                    <span class="glyphicon glyphicon-plus"></span> {{ trans('clients.add') }}
                </button>
            </div>

            <div class="alert alert-info" v-show="!clients.total">
                {{ trans('clients.no_clients') }}
            </div>

            <!-- BEGIN Clients table-->
            <div class="panel panel-default" v-show="clients.total">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('clients.name') }}</th>
                            <th class="text-center">{{ trans('clients.phone_number') }}</th>
                            <th class="text-center">{{ trans('clients.email') }}</th>
                            <th class="text-center">{{ trans('clients.number_of_orders') }}</th>
                            <th class="text-center">{{ trans('common.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-repeat="client in clients.data">

                            <!-- BEGIN Client name -->
                            <td class="text-center vert-align">
                                <a href="/clients/@{{ client.id }}">@{{ client.name }}</a>
                            </td>
                            <!-- END Client name -->

                            <!-- BEGIN Phone number -->
                            <td class="text-center vert-align">
                                <span v-show="client.phone_number">@{{ client.phone_number }}</span>
                                <span v-show="!client.phone_number">{{ trans('common.not_set') }}</span>
                            </td>
                            <!-- END Phone number -->

                            <!-- BEGIN Email -->
                            <td class="text-center vert-align">
                                <span v-show="client.email">@{{ client.email }}</span>
                                <span v-show="!client.email">{{ trans('common.not_set') }}</span>
                            </td>
                            <!-- END Email -->

                            <!-- BEGIN Number of orders -->
                            <td class="text-center vert-align">
                                <span v-show="client.number_of_orders > 0">@{{ client.number_of_orders }}</span>
                                <span v-show="client.number_of_orders < 1">0</span>
                            </td>
                            <!-- END Number of orders -->

                            <!-- BEGIN Delete button -->
                            <td class="text-center vert-align">
                                <button class="btn btn-default" v-on="click: deleteClient(client.id, clients.current_page, clients.to-clients.from)">
                                    <span class="glyphicon glyphicon-trash"></span> {{ trans('common.delete') }}
                                </button>
                            </td>
                            <!-- END Delete button -->
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

        @include('includes.modals.create-new-client')
    </div>
@endsection

@section('scripts')
    <script src="/js/header-search.js"></script>
    <script src="/js/clients.js"></script>
@endsection