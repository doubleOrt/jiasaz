@php
$map_latitude = $user->location_latitude;
$map_longitude = $user->location_longitude;
@endphp

<ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active show" id="pills-first-tab" data-toggle="pill" href="#pills-first" role="tab" aria-controls="pills-first-tab" aria-selected="true">Location</a>
    </li>
</ul>
<hr />
    <div class="tab-pane fade show active" id="pills-first">
        @include("components.google-maps-map")
    </div>
</div>