<ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active show" id="pills-first-tab" data-toggle="pill" href="#pills-first" role="tab" aria-controls="pills-first-tab" aria-selected="true">Items</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-second-tab" data-toggle="pill" href="#pills-second" role="tab" aria-controls="pills-second-tab" aria-selected="false">Show On Map</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-third-tab" data-toggle="pill" href="#pills-third" role="tab" aria-controls="pills-third-tab" aria-selected="false">Other</a>
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
        <!--Google map-->
        <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 400px">
            <iframe src="https://maps.google.com/maps?q={{$user->location_latitude}},{{$user->location_longitude}}&hl=en&z=15&amp;output=embed" frameborder="0"
            style="border:0;width:100%;height: 100%;" allowfullscreen></iframe>
        </div>
        <!-- End Google Maps-->
    </div>
</div>