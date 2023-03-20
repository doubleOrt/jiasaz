@extends("layouts.app")

@section("page_title")
    Available Deliveries
@endsection


@section("content")
<!-- PAGE CONTENT-->
<div class="page-content--bgf7 mt-5">
    <!-- BREADCRUMB-->
    <section class="au-breadcrumb2">
        <div class="container">
            @component('delivery-person.available-deliveries-table')
                @slot("available_deliveries_rows")
                    @foreach($orders as $order)
                        @include("delivery-person.available-deliveries-table-single-row")
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </section>
</div>

@include("components.map-modal")
@endsection

