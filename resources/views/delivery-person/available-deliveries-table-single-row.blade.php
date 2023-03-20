@php

$shop = $order->shop;
$shop_id = $shop->id;
$shop_name = $shop->first_name . " " . $shop->last_name;
$shop_latitude = $shop->location_latitude;
$shop_longitude = $shop->location_longitude;

$customer = $order->customer;
$customer_id = $customer->id; 
$customer_name = $customer->first_name . " " . $customer->last_name;
$customer_latitude = $customer->location_latitude;
$customer_longitude = $customer->location_longitude;

$date_approved = $order->order_responses->where("approved_or_rejected", 1)->first()->date_of_response;

$MAP_MODAL_ID = "mapModal";
@endphp

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>
    <a class="text-secondary" href="/profile/{{$shop_id}}">
        {{$shop_name}}
    </a>
    <button class="btn btn-primary btn-sm showLocationOnMap" data-toggle="modal" data-target="#{{$MAP_MODAL_ID}}" data-location-latitude="{{$shop_latitude}}" data-location-longitude="{{$shop_longitude}}">
        <i class="fas fa-map-marker-alt"></i>
    </button>
</td>
<td>   
    <a class="text-secondary" href="/profile/{{$customer_id}}">
        {{$customer_name}}
    </a>
    <span class="block-email smallBlock mt-1">+{{$order->customer->phone_no}}</span>
    <button class="btn btn-primary btn-sm mt-1 showLocationOnMap" data-toggle="modal" data-target="#{{$MAP_MODAL_ID}}" data-location-latitude="{{$customer_latitude}}" data-location-longitude="{{$customer_longitude}}"><i class="fas fa-map-marker-alt"></i></button>
</td>
<td>{{$order->id}}</td>
<td>{{$order->item->title}}</td>
<td>{{$order->quantity}}</td>
<td>{{$date_approved}}</td>
<td>
    <input class="bg-light makeDeliveryOfferFeeInput" type="number" placeholder="Fee..." min="0.01" step="0.01"/>
    <small class="form-text text-muted">(In USD)</small>
</td>
<td>
    <div class="table-data-feature">
        <form class="makeDeliveryOfferForm" method="POST" action="/make-delivery-offer">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}" />
            <input class="makeDeliveryOfferFeeInputHidden" type="hidden" name="delivery_fee" value="" />
            <button class="makeDeliveryOfferButton btn btn-primary btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Make Offer">
                Make Delivery
            </button>
        </form>
    </div>
</td>
</tr>