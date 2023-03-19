@php
$PENDING_ITEM_CLASS = "text-warning";
@endphp

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>#{{$delivery->id}}</td>
<td class="desc">{{$delivery->order_id}}</td>
<td>
    <a href="/profile/{{$delivery->delivery_person->id}}">
        {{$delivery->delivery_person->first_name . " " . $delivery->delivery_person->last_name}}
    </a>
</td>
<td>
    <span class="block-email">{{$delivery->delivery_person->email}}</span>
    <span class="block-email mt-1">+{{$delivery->delivery_person->phone_no}}</span>
</td>
<td>{{$delivery->date_offer_made}}</td>
<td class="text-success">${{$delivery->delivery_fee}}</td>
<td>
    <div class="table-data-feature">
        <form method="POST" action="/approve-delivery-offer">
            @csrf
            <input type="hidden" name="delivery_id" value="{{$delivery->id}}" />
            <button class="item" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Accept">
            <i class="fa fa-check"></i>
        </button>
        </form>
        &nbsp;
        <form method="POST" action="/reject-delivery-offer">
            @csrf
            <input type="hidden" name="delivery_id" value="{{$delivery->id}}" />
            <button class="item" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reject">
                <i class="fa fa-close"></i>
            </button>
        </form>
    </div>
</td>
</tr>
