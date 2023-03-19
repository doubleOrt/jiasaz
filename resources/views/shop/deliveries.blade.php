@extends("layouts.app")

@section("page_title")
Deliveries
@endsection 

@php
    $PAGE_MAIN_TEXT = "Deliveries";
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
            @component('components.shop-deliveries-table')
                @slot("delivery_rows")
                    @foreach ($deliveries as $delivery) 
                       @include("components.shop-deliveries-table-single-row")
                    @endforeach
                @endslot
            @endcomponent

            </div>
        </section>
    </div>

@endsection