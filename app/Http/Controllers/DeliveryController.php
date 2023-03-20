<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Cookie;

class DeliveryController extends Controller {

    // Shows delivery offers made to a specific shop
    public function show_requests_to_shop() {
        return view("shop.delivery-requests", [
           "deliveries" => Delivery::where("shop_id", auth()->user()->id)
            ->whereNull("offer_reply")
            ->get()
        ]);
    }

    // Shows delivery offers made to a specific shop that the shop replied to previously.
    public function show_shop_deliveries() {
        return view("shop.deliveries", [
            "deliveries" => Delivery::where("shop_id", auth()->user()->id)
             ->whereNotNull("offer_reply")
             ->get()
         ]);   
    }

    public function make_delivery_offer(Request $request) {

        $user = auth()->user();
        if (!$user->role == User::$ROLES["delivery_person"]) {
            return redirect()->back()->with("error", "You don't have the permission to make a delivery offer!");
        }

        $validated_data = $request->validate([
            "order_id" => "required|exists:orders,id",
            "delivery_fee" => "required|numeric|min:0.01",
        ]);

        $order = Order::find($validated_data["order_id"]);

        $delivery_offer = new Delivery();
        $delivery_offer->shop_id = $order->shop->id;
        $delivery_offer->order_id = $order->id;
        $delivery_offer->delivery_person_id = $user->id;
        $delivery_offer->delivery_fee = $validated_data["delivery_fee"];
        $delivery_offer->save();

        return redirect()->back()->with("success", "Delivery offer made!");
    }

    public function get_available_deliveries() {
        $delivery_person_id = auth()->user()->id;
        /* We need to build this fairly complex query so that we don't return orders to
         * which the user has already made an offer but hasn't been replied to
        */
        $orders = Order::where('status', 'approved')
                ->whereDoesntHave('deliveries', function ($query) use ($delivery_person_id) {
                    $query->where('delivery_person_id', $delivery_person_id)
                        ->whereNull('offer_reply');
                })
                ->get();

        return $orders;
    }

    public function show_available_deliveries() {
        $available_deliveries = $this->get_available_deliveries();
        return view("delivery-person.show-available-deliveries", [
            "orders" => $available_deliveries,
        ]);
    }

    // Allows shops to approve a delivery offer
    public function approve_offer(Request $request) {

        $delivery = Delivery::find($request->delivery_id);

        // Ensure that the user is the shop owner
        if ($request->user()->id != $delivery->shop_id) {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
        
        
        $delivery->order->setInDelivery($delivery->id);
        $delivery->order->save();

        // Update the delivery request
        $delivery->offer_reply = true;
        $delivery->date_offer_replied_to = Carbon::now();
        $delivery->save();
        
        return redirect()->back()->with('success', 'You have accepted the delivery offer.');
    }

    // Allows shops to reject a delivery offer
    public function reject_offer(Request $request) {

        $delivery = Delivery::find($request->delivery_id);

        // Ensure that the user is the shop owner
        if ($request->user()->id != $delivery->shop_id) {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        // Update the delivery request
        $delivery->offer_reply = false;
        $delivery->date_offer_replied_to = Carbon::now();
        $delivery->save();
        
        return redirect()->back()->with('success', 'You have rejected the delivery offer.');
    }
}
