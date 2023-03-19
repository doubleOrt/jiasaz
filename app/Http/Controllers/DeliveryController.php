<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    public function show_requests_to_shop() {
        return view("shop.delivery-requests", [
           "deliveries" => Delivery::where("shop_id", auth()->user()->id)->take(10)->get()
        ]);
    }
}
