@extends("layouts.app")

@section("page_title")
    Shop Orders
@endsection

@section("content")
<!-- PAGE CONTENT-->
<div class="page-content--bgf7 mt-5">
    <!-- BREADCRUMB-->
    <section class="au-breadcrumb2">
        <div class="container">
            @component('components.delivery-requests-table')
                @slot("delivery_rows")
                    @foreach($deliveries as $delivery)
                        @include("components.delivery-requests-table-single-row")
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </section>
</div>
@endsection