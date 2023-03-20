@php

$shop = $delivery->shop;
$shop_id = $shop->id;
$shop_name = $shop->first_name . " " . $shop->last_name;
$shop_latitude = $shop->location_latitude;
$shop_longitude = $shop->location_longitude;

$customer = $delivery->order->customer;
$customer_id = $customer->id; 
$customer_name = $customer->first_name . " " . $customer->last_name;
$customer_phone_no = $customer->phone_no;
$customer_latitude = $customer->location_latitude;
$customer_longitude = $customer->location_longitude;

$MAP_MODAL_ID = "mapModal";
@endphp

<tr>
    <td>#{{$delivery->id}}</td>
    <td>
        <a class="text-secondary" href="/profile/{{$shop_id}}">
            {{$shop_name}}
        </a>
        <br />
        <button class="btn btn-primary btn-sm showLocationOnMap" data-toggle="modal" data-target="#{{$MAP_MODAL_ID}}" data-location-latitude="{{$shop_latitude}}" data-location-longitude="{{$shop_longitude}}">
            <i class="fas fa-map-marker-alt"></i>
        </button>
    </td>
    <td>#{{$delivery->order->id}}</td>
    <td>
        <a class="text-secondary" href="/profile/{{$customer_id}}">
            {{$customer_name}}
        </a>
        <span class="block-email smallBlock mt-1">+{{$customer_phone_no}}</span>
        <br />
        <button class="btn btn-primary btn-sm mt-1 showLocationOnMap" data-toggle="modal" data-target="#{{$MAP_MODAL_ID}}" data-location-latitude="{{$customer_latitude}}" data-location-longitude="{{$customer_longitude}}"><i class="fas fa-map-marker-alt"></i></button>
    </td>
    <td class="text-success">${{$delivery->delivery_fee}}</td>
    <td>{{$delivery->date_offer_replied_to}}</td>
    <td>{{$delivery->date_delivered}}</td>
  </tr>