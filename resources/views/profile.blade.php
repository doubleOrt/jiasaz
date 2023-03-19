@extends("layouts.app")

@php
    $ORDER_ITEM_MODAL_ID = "orderItemModal";
    $ORDER_ITEM_MODAL_CONFIRM_BUTTON_ID = "orderItemModalConfirmOrderButton";
@endphp

@section("content")

<!-- PAGE CONTENT-->
<div class="page-content--bgf7 mt-5">
    <!-- BREADCRUMB-->
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row justify-content-center mt-3 mb-3">
                <div class="col-md-4">
                    @include("components.profile-card")
                </div>
            <div class="row bg-white py-6">
                <div class="col-md-12">
                    <ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="true">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Other</a>
                        </li>
                    </ul>
                    <hr />
                    <div class="col-md-12 pd-3">
                        @component('components.orders-table0')
                            @slot("order_rows")
                                @foreach ($orders as $order) 
                                    @include("components.orders-table0-single-row")
                                @endforeach
                            @endslot
                        @endcomponent
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>

@include("components.order-item-modal")

@endsection