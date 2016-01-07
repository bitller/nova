@extends('layout')
@section('content')
    <div id="offer" offer-id="{{ $offerId }}">
        @include('includes.ajax-translations.common')

        <!-- BEGIN Top part -->
        <div class="add-product-button row">
            <span class="avon-products">{{ trans('offers.offer_details') }}</span>&nbsp;

            @include('includes.admin-center.buttons.more-options-dropdown', [
            'icon' => 'glyphicon-th',
            'items' => [
                [
                    'url' => '/admin-center/subscriptions/offers',
                    'name' => trans('offers.go_back_to_offers'),
                    'icon' => 'glyphicon-arrow-left',
                ],
                [
                    'url' => '#',
                    'name' => trans('offers.delete_offer'),
                    'icon' => 'glyphicon-trash',
                    'data_toggle' => 'modal',
                    'data_target' => '#delete-offer-modal',
                    'on_click' => 'resetDeleteOfferModal'
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
        <div class="row" v-show="loaded">
            <div class="panel panel-default">
                <div class="list-group">
                    <a href="#" class="list-group-item active">{{ trans('offers.offer_details') }}</a>

                    <!-- BEGIN Offer name -->
                    <a data-toggle="modal" data-target="#edit-offer-name-modal" href="#" class="list-group-item"><span class="badge">@{{ offer.name }}</span>{{ trans('offers.offer_name') }}</a>
                    <!-- END Offer name -->

                    <!-- BEGIN Offer amount -->
                    <a href="#" class="list-group-item"><span class="badge">@{{ offer.amount }}</span>{{ trans('offers.amount') }}</a>
                    <!-- END Offer amount -->

                    <!-- BEGIN Offer promo code -->
                    <a href="#" class="list-group-item"><span class="badge">@{{ offer.promo_code }}</span>{{ trans('offers.promo_code') }}</a>
                    <!-- END Offer promo code -->

                    <!-- BEGIN Offer is used on sign up -->
                    <a href="#" class="list-group-item">
                        <span class="badge">
                            <span v-show="offer.use_on_sign_up">{{ ucfirst(trans('common.yes')) }}</span>
                            <span v-show="!offer.use_on_sign_up">{{ ucfirst(trans('common.no')) }}</span>
                        </span>
                        {{ trans('offers.is_this_offer_used_on_sign_up') }}
                    </a>
                    <!-- END Offer is used on sign up -->

                    <!-- BEGIN Offer is disabled -->
                    <a href="#" class="list-group-item">
                        <span class="badge">
                            <span v-show="offer.disabled">{{ ucfirst(trans('common.no')) }}</span>
                            <span v-show="!offer.disabled">{{ ucfirst(trans('common.yes')) }}</span>
                        </span>
                        {{ trans('offers.is_this_offer_enabled') }}
                    </a>
                    <!-- END Offer is disabled -->

                    <!-- BEGIN Offer associated subscriptions -->
                    <a href="#" class="list-group-item"><span class="badge">@{{ offer.associated_subscriptions }}</span>{{ trans('offers.associated_subscriptions') }}</a>
                    <!-- END Offer associated subscriptions -->
                </div>
            </div>
        </div>
        <!-- END Offers table -->

        @include('includes.modals.edit-offer-name')

        @endsection

        @section('scripts')
            <script src="/js/offer.js"></script>
@endsection