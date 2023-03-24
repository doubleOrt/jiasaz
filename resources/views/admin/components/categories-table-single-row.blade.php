
<tr data-category-id="{{$category->id}}">
    <td>{{$category->id}}</td>
    <td class="categoryName" contenteditable="true">{{$category->name}}</td>
    <td class="ordersTable0ItemDescription categoryDescription" contenteditable="true">
        {{$category->description}}
    </td>
    <td>
        <input type="color" name="category_color" value="{{$category->color}}"/>
        <br />
        <small>{{$category->color}}</small>
    </td>
    <td>{{$category->date_added}}</td>
    <td>{{$category->admin->first_name . " " . $category->admin->last_name}}</td>
    <td>
        <a href="/category/{{$category->id}}">
            <span class="block-email smallBlock">
                Items: <strong>{{$category->items->count()}}</strong>
            </span>
        </a>    
            @php
                $orders_for_this_category = App\Models\Order::whereNotIn('status', ['pending', 'rejected'])
                    ->whereHas('item', function ($query) use ($category) {
                        $query->where("category_id", $category->id);
                    });

                $qt_orders_for_category = $orders_for_this_category->sum("quantity");
                // total money for orders of items of the current category
                $value_of_orders_for_category = $orders_for_this_category->get()->sum(function($order) {
                    return $order->quantity * $order->item->price;
                });
            
            @endphp
            <span class="block-email smallBlock">
                Qt. Orders: 
                <strong>
                    {{$qt_orders_for_category}}
                </strong>
            </span>
            <span class="block-email smallBlock">Val. Orders: 
                <span class="text-success">
                    ${{$value_of_orders_for_category}}
                </span>
            </span>
    </td>
    <td>
        <div class="checkbox text-center">
            <input type="checkbox" id="displayedInNavbar{{$category->id}}" name="displayed_in_navbar" class="form-check-input" 
                {{$category->displayed_in_navbar ? "checked" : ""}}/>
        </div>
    </td>
    <td>
        <button type="submit" class="btn btn-primary btn-sm updateCategorySaveButton">
            <i class="fa fa-save"></i> &nbsp;Save
        </button>
    </td>

</tr>