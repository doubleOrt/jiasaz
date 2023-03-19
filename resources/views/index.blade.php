@extends("layouts.app");

@php
    $ORDER_ITEM_MODAL_ID = "orderItemModal";
    $ORDER_ITEM_MODAL_CONFIRM_BUTTON_ID = "orderItemModalConfirmOrderButton";
    $PAGE_MAIN_TEXT = "Browse items listed for sale...";   
@endphp

@include("php-utils")

@section("content")

<!-- PAGE CONTENT-->
 <div class="page-content--bgf7 mt-5">
    <!-- BREADCRUMB-->
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row text-center mt-3 mb-3">
                <div class="col-md-12 text-left">
                    <h3 class="ml-3">{{ $PAGE_MAIN_TEXT }}</h3>
                </div>
                <div class="col md-12"><hr /></div>
            </div>
            <div class="row">

                @foreach ($first_ten_items as $item)
                    @include("components.item-card", [
                        "item" => $item
                    ])
                @endforeach

            </div>
        </div>
    </section>
</div>

@include("components.order-item-modal")

@endsection