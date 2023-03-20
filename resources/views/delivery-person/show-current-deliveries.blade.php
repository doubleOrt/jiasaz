@extends("layouts.app")

@section("page_title")
    Deliveries
@endsection


@section("content")
<!-- PAGE CONTENT-->
<div class="page-content--bgf7 mt-5">
    <!-- BREADCRUMB-->
    <section class="au-breadcrumb2">
        <div class="container">
            @component('delivery-person.current-deliveries-table')
                @slot("current_deliveries_rows")
                    @foreach($current_deliveries as $delivery)
                        @include("delivery-person.current-deliveries-table-single-row")
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </section>
</div>

@include("components.map-modal")
@endsection

