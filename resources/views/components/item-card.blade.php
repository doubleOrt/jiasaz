
{{-- This is very inefficient but it's only a fallback in case we forget to include this file before iterating through items --}}
@if(!function_exists("haversineGreatCircleDistance"))
    @include("php-utils")
@endif

@php

$user_lat = auth()->user()->location_latitude;
$user_long = auth()->user()->location_longitude;
$shop_lat = $item->shop->location_latitude;
$shop_long = $item->shop->location_longitude;

$distance_from_user = round(haversineGreatCircleDistance($user_lat, $user_long, $shop_lat, $shop_long), 2);

$context = stream_context_create(
    array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
            )
        )
    );

$shop_location_latitude = $item->shop->location_latitude;
$shop_location_longitude = $item->shop->location_longitude;
$shop_address_request = json_decode(
    file_get_contents("https://nominatim.openstreetmap.org/reverse?format=json&lat=$shop_location_latitude&lon=$shop_location_longitude&accept-language=en-us", false, $context)
);

$shop_address = $shop_address_request->address;
$shop_country = $shop_address->country;
$shop_district = $shop_address->district;

// so that only users can see the item ordering buttons (and any other functionality required)
$disable_ordering_functionality = !(auth()->user()->role == "user") ? true : false;
@endphp

<div class="col-md-4">
    <div class="card itemCard" data-item-id="{{ $item->id }}">
    <div class="itemCardImageContainer">
        <a href="{{$item->image_path}}">
            <img class="card-img-top" src="{{$item->image_path}}" alt="Card image cap">
        </a>
    </div>
    <div class="card-body">
        <h4 class="card-title mb-0">{{ $item->title }}</h4>
        <span class="badge badge-pill font-weight-normal mb-1 itemCategory" style="background-color: {{$item->category->color}}">
            <a href="/category/{{$item->category->id}}">{{$item->category->name}}</a>
        </span>
        <h6 class="text-secondary font-weight-normal">
            <small class="text-muted">By</small> <a class="text-secondary" href="/user-items/{{$item->shop->id}}">
                <span class="font-weight-bold itemSeller">{{$item->shop->first_name . " " . $item->shop->last_name}}</span>
            </a>
        </h6>
        <h6 class="text-secondary font-weight-normal">
            <small class="text-muted">Price:</small> <span class="text-success font-weight-bold itemPrice">${{ $item->price }}</span>
        </h6>
        <h6 class="text-secondary font-weight-normal">
            <small class="text-muted">Stock: <span class="text-secondary itemAmountInStock">{{ $item->amount_currently_in_stock }}</span></small>
        </h6>
        <h6 class="text-secondary font-weight-normal mb-1">
            <small class="text-muted">Location: <span class="text-secondary">{{ $shop_district . ", " . $distance_from_user }} km</span></small>
        </h6>
        <p class="card-text">
            {{ $item->description }}
        </p>
        @if(!isset($disable_ordering_functionality) || $disable_ordering_functionality == false)
            <hr />
            <div class="col-md-12 text-center mt-3">
                <button type="button" class="btn btn-primary orderItemButton" data-toggle="modal" data-target="#{{$ORDER_ITEM_MODAL_ID}}">
                    Order Item
                </button>
            </div>
        @endif
    </div>
    </div>
</div>