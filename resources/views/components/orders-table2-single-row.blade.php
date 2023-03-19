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
    <td>{{$order->id}}</td>
    <td>{{$order->item->title}}</td>
    <td>
      <a class="text-secondary" href="/profile/{{$order->customer->id}}">
        {{$order->customer->first_name . " " . $order->customer->last_name}}
      </a>
    </td>
    <td>{{$order->quantity}}</td>
    <td>${{$order->item->price * $order->quantity}}</td>
    <td>{{$order->date_order_placed}}</td>
    <td class="{{$class_based_on_status[$order->status]}}">{{$text_based_on_status[$order->status]}}</td>
  </tr>