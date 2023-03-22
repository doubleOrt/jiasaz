@extends("admin.app")

@php
    $user = auth()->user();
@endphp

@include("php-utils")


@section("content")
    <!-- PAGE CONTENT-->
    <div class="page-content--bgf7">
        <!-- BREADCRUMB-->
        <section class="au-breadcrumb2">
            <div class="container">
                <div class="row justify-content-center">
                    @include("admin.components.add-category-form")
                </div>
            </div>
        </section>
    </div>
@endsection
