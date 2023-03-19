<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;
use Carbon\Carbon;

class DeliveryController extends Controller {
    // shows delivery offers made to a specific shop
    public function show_requests_to_shop() {
        return view("shop.delivery-requests", [
           "deliveries" => Delivery::where("shop_id", auth()->user()->id)
            ->whereNull("offer_reply")
            ->get()
        ]);
    }

    public function show_shop_deliveries() {
        return view("shop.deliveries", [
            "deliveries" => Delivery::where("shop_id", auth()->user()->id)
             ->whereNotNull("offer_reply")
             ->get()
         ]);   
    }

    public function approve_offer(Request $request) {

        $delivery = Delivery::find($request->delivery_id);

        // Ensure that the user is the shop owner
        if ($request->user()->id != $delivery->shop_id) {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
        
        $delivery->order->status = Order::$STATUS_IN_DELIVERY;
        $delivery->order->save();

        // Update the delivery request
        $delivery->offer_reply = true;
        $delivery->date_offer_replied_to = Carbon::now();
        $delivery->save();
        
        return redirect()->back()->with('success', 'You have accepted the delivery offer.');
    }

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
