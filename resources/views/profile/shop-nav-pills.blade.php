@php
$map_latitude = $user->location_latitude;
$map_longitude = $user->location_longitude;
@endphp

<ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active show" id="pills-first-tab" data-toggle="pill" href="#pills-first" role="tab" aria-controls="pills-first-tab" aria-selected="true">Items</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-second-tab" data-toggle="pill" href="#pills-second" role="tab" aria-controls="pills-second-tab" aria-selected="false">Location</a>
    </li>
</ul>
<hr />
<div class="col-md-12 p-3 tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-first">
        <div class="row">
            @foreach ($items as $item)
                @include("components.item-card", [
                    "item" => $item
                ])
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="pills-second">
        @include("components.google-maps-map")
    </div>
</div>