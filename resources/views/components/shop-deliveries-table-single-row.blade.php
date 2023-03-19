@php

$class_based_on_status = [
  "pending" => "text-warning",
  "approved" => "text-info",
  "rejected" => "text-danger",
  "in_delivery" => "text-primary",
  "delivered" => "text-success",
];

$text_based_on_status = [
  "pending" => "Pending",
  "approved" => "Approved",
  "rejected" => "Rejected",
  "in_delivery" => "In Delivery",
  "delivered" => "Delivered",
];

@endphp
<tr>
    <td>#{{$delivery->id}}</td>
    <td>#{{$delivery->order_id}}</td>
    <td>
        <a href="/profile/{{$delivery->delivery_person->id}}">
            {{$delivery->delivery_person->first_name . " " . $delivery->delivery_person->last_name}}
        </a>
    </td>
    <td>{{$delivery->delivery_person->email . " " . $delivery->delivery_person->phone_no}}</td>
    <td class="text-success">${{$delivery->delivery_fee}}</td>
    <td>{{$delivery->date_offer_made}}</td>
    <td>{{$delivery->date_offer_replied_to}}</td>
    @if($delivery->offer_reply == true) 
        <td class="{{$class_based_on_status[$delivery->order->status]}}">
            {{$text_based_on_status[$delivery->order->status]}}
        </td>
    @else
        {{-- purely cosmetic otherwise the logic doesn't make sense since "rejected" here represents that the delivery offer was rejected not the order request --}}
        <td class="{{$class_based_on_status['rejected']}}">
            Rejected
        </td>
    @endif
  </tr>