@php

$shop_full_name = $item->shop->first_name . " " . $item->shop->last_name;

@endphp

<tr data-item-id="{{$item->id}}">
    <td>{{$item->id}}</td>
    <td class="itemTitle" contenteditable="true">{{$item->title}}</td>
    <td class="ordersTable0ItemDescription itemDescription" contenteditable="true">
        {{$item->description}}
    </td>
    <td>
        <a href="/profile/{{$item->shop->id}}">
            {{$shop_full_name}}
        </a>
    </td>
    <td>
        <select class="tablesSelectInputs updateItemCategorySelectInput" class="form-control">
            @foreach($categories as $category)
                <option value="{{$category->id}}" {{$category->id == $item->category->id ? "selected" : ""}}>{{$category->name}}</option>
            @endforeach
        </select>
    </td>
    <td class="text-success">$<span class="itemPrice" contenteditable="true">{{$item->price}}</span></td>
    <td>{{$item->amount_currently_in_stock}}</td>
    <td>{{$item->date_added}}</td>
    <td>
        <label for="updateItemImageInput{{$item->id}}">
            <img class="imageWithHoverAndActiveEffects" src="{{$item->image_path}}" alt="Item Image" width="150px" draggable="false" />
        </label>
        <input type="file" style="display:none" id="updateItemImageInput{{$item->id}}" class="updateItemImageInput" name="item_image" />
    </td>
    <td>
        @php
            // item orders that are not pending or rejected
            $item_orders = $item->orders->whereNotIn("status", [App\Models\Order::$STATUS_PENDING, App\Models\Order::$STATUS_REJECTED]);

        @endphp
        <span class="block-email smallBlock">
            No. Orders: 
            <strong>
                {{$item_orders->count();}}
            </strong>
        </span>
        <span class="block-email smallBlock mt-1">
            Qt. sold: 
            <strong>
                {{$item_orders->sum("quantity")}}
            </strong>
        </span>
    </td>
    <td>
        <button class="btn btn-primary btn-sm updateItemSaveButton">
            <i class="fa fa-save"></i> &nbsp;Save
        </button>
        <button class="btn btn-danger btn-sm mt-1 itemDeleteButton" data-toggle="modal" data-target="#deleteItemModal">
            <i class="fa fa-trash"></i> Delete
        </button>
    </td>

</tr>