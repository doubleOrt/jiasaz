@extends("layouts.app")

@section("page_title")
Order
@endsection 

@php
    $PAGE_MAIN_TEXT = "Order History...";
@endphp

@section("content")

    <!-- PAGE CONTENT-->
    <div class="page-content--bgf7 mt-5">
        <!-- BREADCRUMB-->
        <section class="au-breadcrumb2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <h3 class="ml-3">{{ $PAGE_MAIN_TEXT }}</h3>
                    </div>
                    <div class="col md-12"><hr /></div>
                </div>
            @component('components.orders-table0')
                @slot("order_rows")
                    @foreach ($orders as $order) 
                        @include("components.orders-table0-single-row")
                    @endforeach
                @endslot
            @endcomponent

            </div>
        </section>
    </div>

@endsection