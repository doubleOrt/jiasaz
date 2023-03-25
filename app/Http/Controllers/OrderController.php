<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use App\Models\OrderResponse;
use App\Models\Delivery;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller {

    // retrieve all orders
    public function index()
    {
        $orders = Order::with('customer', 'shop', 'item')->get();
        return view('orders.index', compact('orders'));
    }

    // shows all the orders made to a particular shop
    public function show_all_to_shop($shop_id) {
        $orders = Order::where("shop_id", $shop_id)->get()->sortByDesc("id");
        return view("shop.orders-history", [
            "orders" => $orders,
            "for_logged_in_user" => false,
        ]);
    }

    public function show_all_from_user($user_id) {
        $logged_in_user = Auth()->user();
        if (!$logged_in_user->can("view customer orders") && $logged_in_user->id != $user_id) {
            return redirect()->back()->with("error", "You don't have permission to view customer orders.");
        }
        $user = User::find($user_id);
        $orders = $user->orders->sortByDesc("id");
        return view("orders.show", [
            "orders" => $orders,
            "for_logged_in_user" => true,
        ]);
    }

    // show a single order
    public function show($order_id)
    {
        $user = auth()->user();
        $orders = Order::find($order_id);
        $order->load('customer', 'shop', 'item', 'delivery', 'order_responses');
        return view(route('orders.show', $user->id), [
            "order" => $order
        ]);
    }

    // create a new order
    public function store(Request $request) {

        $item = Item::find($request->item_id);

        // requested item does not exist in database, return error;
        if (!$item) {
            $error = ValidationException::withMessages([
                'item_id' => ['Item does not exist in our database!'],
             ]);
             throw $error;
        }

        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1|max:' . $item->amount_currently_in_stock
        ]);

        $order = new Order();
        $order->item_id = $validatedData['item_id'];
        $order->shop_id = $item->shop_id;
        $order->customer_id = auth()->id();
        $order->quantity = $validatedData['quantity'];
        $order->save();

        return redirect()->route('orders.show', Auth()->user()->id);
    }
    

    // mark an order as in delivery or delivered
    public function markAsDelivered(Request $request, $id)
	{
		$order = Order::findOrFail($id);

		if ($order->status !== 'in_delivery') {
			return response()->json(['message' => 'Order is not in delivery'], 422);
		}

		$order->status = 'delivered';
		$order->save();

		$delivery = $order->delivery;
		$delivery->date_delivered = now();
		$delivery->save();

		$item = $order->item;
		$item->amount_currently_in_stock -= $order->quantity;
		$item->save();

		return response()->json(['message' => 'Order marked as delivered'], 200);
	}

    /**
     * Approve an order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {

        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::find($validatedData["order_id"]);
        $shop = auth()->user();
        if (!$order->shop_id == $shop->id) {
            return redirect()->route("main_page")->with("error", "ID of logged in user doesn't match ID of shop owner!");
        }

        if ($order->status == "pending") {
            $order->approve();

            // Send notification to customer that their order has been approved
            // ... 

            return redirect()->route("main_page")->with("success", 'Order has been approved.');
        } else {
            return redirect()->route("main_page")->with("error", "Order cannot be approved because status is not 'pending'.");
        }
    }

    /**
     * Reject an order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request) {

        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::find($validatedData["order_id"]);
        $shop = auth()->user();
        if (!$order->shop_id == $shop->id) {
            return redirect()->route("main_page")->with("error", "ID of logged in user doesn't match ID of shop owner!");
        }

        if ($order->status == "pending") {
            $order->reject(null);

            // Send notification to customer that their order has been approved
            // ... 

            return redirect()->route("main_page")->with("success", 'Order has been rejected.');
        } else {
            return redirect()->route("main_page")->with("error", "Order cannot be rejected because status is not 'pending'.");
        }
    }

    /**
     * Get all orders for a given shop.
     *
     * @param  int  $shopId
     * @return \Illuminate\Http\Response
     */
    public function shopOrders($shopId) {
        $orders = Order::where('shop_id', $shopId)->get();

        return view('orders.index', compact('orders'));
    }

    public function admin_view_orders() {
        return view("admin.view-orders", [
            "orders" => Order::all(),
        ]);
    }

    public function cancel(Request $request) {
        $user = Auth()->user();
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        if ($order->status == "pending" && $order->customer_id == auth()->user()->id) {
            $order->delete();
            return redirect()->route("orders.show", $user->id)->with("success", "Order cancelled.");
        }
        return redirect()->route("orders.show", $user->id)->with("error", "Failed to cancel order!");
    }

    public function destroy($id) {
        $order = Order::find($id);
        $order->delete();

        return redirect()->route("orders.show", Auth()->user()->id);
    }
}