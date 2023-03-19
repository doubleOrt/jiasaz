@php
$PENDING_ITEM_CLASS = "text-warning";
@endphp

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>#{{$order->id}}</td>
<td class="desc">{{$order->item->title}}</td>
<td>
    <a class="text-secondary" href="/profile/{{$order->customer->id}}">
        {{$order->customer->first_name . " " . $order->customer->last_name}}
    </a>
</td>
<td>
    <span class="block-email">{{$order->customer->email}}</span>
    <span class="block-email mt-1">+{{$order->customer->phone_no}}</span>
</td>
<td>{{$order->quantity}}</td>
<td>${{$order->item->price * $order->quantity}}</td>
<td>{{$order->date_order_placed}}</td>
<td>
    <div class="table-data-feature">
        <form method="POST" action="/approve-order">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}" />
            <button class="item" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Accept">
            <i class="fa fa-check"></i>
        </button>
        </form>
        &nbsp;
        <form method="POST" action="/reject-order">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}" />
            <button class="item" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reject">
                <i class="fa fa-close"></i>
            </button>
        </form>
    </div>
</td>
</tr>
