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
            @component('components.orders-table1')
                @slot("order_rows")
                    @foreach($orders as $order)
                        @include("components.orders-table1-single-row")
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </section>
</div>
@endsection