@extends("layouts.app")

@php
    $ORDER_ITEM_MODAL_ID = "orderItemModal";
    $ORDER_ITEM_MODAL_CONFIRM_BUTTON_ID = "orderItemModalConfirmOrderButton";
    $PAGE_MAIN_TEXT = "Browse items listed for sale...";

    /**
    * Calculates the great-circle distance between two points, with
    * the Haversine formula.
    * @param float $latitudeFrom Latitude of start point in [deg decimal]
    * @param float $longitudeFrom Longitude of start point in [deg decimal]
    * @param float $latitudeTo Latitude of target point in [deg decimal]
    * @param float $longitudeTo Longitude of target point in [deg decimal]
    * @param float $earthRadius Mean earth radius in [m]
    * @return float Distance between points in [m] (same as earthRadius)
    */
    function haversineGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
    }
        
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