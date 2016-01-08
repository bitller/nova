@extends('layout')
@section('content')
    <div id="offers">
        @include('includes.ajax-translations.common')
        {{--<div>--}}
            <!-- BEGIN Top part -->
            <div class="add-product-button row">
                <span class="avon-products">{{ trans('offers.offers') }}</span>&nbsp;

                @include('includes.admin-center.buttons.more-options-dropdown', [
                'icon' => 'glyphicon-th',
                'items' => [
                    [
                        'url' => '/admin-center/subscriptions',
                        'name' => trans('offers.go_back_to_subscriptions'),
                        'icon' => 'glyphicon-arrow-left',
                    ],
                    [
                        'url' => '#',
                        'name' => trans('offers.create_new_offer'),
                        'icon' => 'glyphicon-plus',
                        'data_toggle' => 'modal',
                        'data_target' => '#create-new-offer-modal',
                        'on_click' => 'resetCreateNewOfferModal'
                    ]
                ]
                ])

                <div class="btn-group pull-right">
                    @include('includes.admin-center.buttons.users-manager')
                    @include('includes.admin-center.buttons.products-manager')
                    @include('includes.admin-center.buttons.logs')
                    @include('includes.admin-center.buttons.application-settings')
                    @include('includes.admin-center.buttons.more')
                </div>
            </div>
        <!-- END Top part -->

        <!-- BEGIN Offers table -->
        <div class="row" v-show="!loading">
            <div class="panel panel-default">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">{{ trans('offers.offer_name') }}</th>
                        <th class="text-center">{{ trans('offers.price') }}</th>
                        <th class="text-center">{{ trans('offers.promo_code') }}</th>
                        <th class="text-center">{{ trans('offers.is_this_offer_used_on_sign_up') }}</th>
                        <th class="text-center">{{ trans('offers.is_this_offer_enabled') }}</th>
                        <th class="text-center">{{ trans('offers.associated_subscriptions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="offer in offers.data">
                        <td class="text-center"><a href="/admin-center/subscriptions/offers/@{{ offer.id }}">@{{ offer.name }}</a></td>
                        <td class="text-center">@{{ offer.amount }}</td>
                        <td class="text-center">
                            <span v-show="offer.promo_code">@{{ offer.promo_code }}</span>
                            <span v-show="!offer.promo_code">{{ trans('common.not_set') }}</span>
                        </td>
                        <td class="text-center">
                            <span v-show="offer.use_on_sign_up > 0" class="glyphicon glyphicon-ok"></span>
                            <span v-show="offer.use_on_sign_up < 1" class="glyphicon glyphicon-cancel"></span>
                        </td>
                        <td class="text-center">
                            <span v-show="offer.disabled">{{ ucfirst(trans('common.no')) }}</span>
                            <span v-show="!offer.disabled">{{ ucfirst(trans('common.yes')) }}</span>
                        </td>
                        <td class="text-center">@{{ offer.associated_subscriptions }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Offers table -->

        <!-- BEGIN Pagination links -->
        <ul class="pager" v-show="actions.total > actions.per_page && !loading_user_actions">
            <li v-class="disabled : !actions.prev_page_url"><a href="#" v-on="click: getUserActions(actions.prev_page_url)">{{ trans('common.previous') }}</a></li>
            <li v-class="disabled : !actions.next_page_url"><a href="#" v-on="click: getUserActions(actions.next_page_url)">{{ trans('common.next') }}</a></li>
        </ul>
        <!-- END Pagination links -->

        @include('includes.modals.create-new-offer')

@endsection

@section('scripts')
    <script src="/js/offers.js"></script>
@endsection