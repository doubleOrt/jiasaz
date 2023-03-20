@extends("layouts.app")

@php
    $ORDER_ITEM_MODAL_ID = "orderItemModal";
    $ORDER_ITEM_MODAL_CONFIRM_BUTTON_ID = "orderItemModalConfirmOrderButton";

    $COMPONENT_BASED_ON_ROLE = [
        "user" => "profile.user-nav-pills",
        "shop_owner" => "profile.shop-nav-pills",
        "delivery_person" => "profile.delivery-person-nav-pills",
    ];
@endphp

@section("content")

<!-- PAGE CONTENT-->
<div class="page-content--bgf7 mt-5">
    <!-- BREADCRUMB-->
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row justify-content-center mt-3 mb-3">
                <div class="col-md-4">
                    @include("profile.profile-card")
                </div>
            <div class="row bg-white py-6">
                <div class="col-md-12">
                    @include($COMPONENT_BASED_ON_ROLE[$user->role])
                </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include("components.order-item-modal")

@endsection