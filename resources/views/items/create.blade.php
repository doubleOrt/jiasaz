@extends("layouts.app")

@php
    $PAGE_MAIN_TEXT = "Add a new item for sale...";
@endphp

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
                <div class="col-md-12"><hr /></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    @include("components.add-item-form")
                </div>
            </div>
        </div>
    </section>
</div>

@endsection