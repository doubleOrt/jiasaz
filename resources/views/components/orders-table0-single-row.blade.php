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
    <td>#{{$order->id}}</td>
    <td>{{$order->item->title}}</td>
    <td class="ordersTable0ItemDescription">{{$order->item->description}}</td>
    <td>
      <a href="/profile/{{$order->shop->id}}">
        {{$order->shop->first_name . " " . $order->shop->last_name}}
      </a>
    </td>
    <td>{{$order->quantity}}</td>
    <td>${{$order->item->price * $order->quantity}}</td>
    <td>{{$order->date_order_placed}}</td>
    <td class="{{$class_based_on_status[$order->status]}}">{{$text_based_on_status[$order->status]}}</td>
    <td>
      @if(isset($for_logged_in_user) && $order->status == 'pending')
        <div class="table-data-feature">
            <form method="POST" action="/cancel-order">
              @csrf
              <input type="hidden" name="order_id" value="{{ $order->id }}" />
              <button class="item" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel Order">
                  <i class="zmdi zmdi-delete"></i>
              </button>
            </form>
        </div>
      @endif
    </td>

  </tr>