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
    <td>
        <a href="/profile/{{$order->shop->id}}" class="text-secondary">
            {{$order->shop->first_name . " " . $order->shop->last_name}}
        </a>
    </td>
    <td>
        <a href="/profile/{{$order->customer->id}}" class="text-secondary">
            {{$order->customer->first_name . " " . $order->customer->last_name}}
        </a>
    </td>
    <td>{{$order->item->title}}</td>
    <td class="text-success">${{$order->item->price}}</td>
    <td>{{$order->quantity}}</td>
    <td>
        <span class="badge badge-pill font-weight-normal mb-1 itemCategory" style="background-color: {{$order->item->category->color}}; font-size: 90%;">
            <a href="/category/{{$order->item->category->id}}">
                {{$order->item->category->name}}
            </a>
        </span>
    </td>
    <td class="{{$class_based_on_status[$order->status]}}">{{$text_based_on_status[$order->status]}}</td>
    <td>{{$order->date_order_placed}}</td>
</tr>