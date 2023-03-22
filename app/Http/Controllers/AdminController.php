<?php

// No corresponding admin model exists but this is just an object where I intend to
// encapsulate some of the logic relating to admins.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{

    public static function GET_DASHBOARD_DATA() {
        return [
            "total_users" => self::GET_NUMBER_OF_USERS(),
            "total_items_sold" => self::GET_NUMBER_OF_ITEMS_SOLD(),
            "total_value_of_items_sold" => self::GET_VALUE_OF_ITEMS_SOLD(),
            "num_orders_this_week" => self::GET_ORDERS_PLACED_THIS_WEEK(),
        ];
    }

    public static function GET_NUMBER_OF_USERS() {
        return User::count();
    }

    public static function GET_NUMBER_OF_ITEMS_SOLD() {
        return Order::where("status", "<>", "pending")->sum("quantity");
    }

    public static function GET_VALUE_OF_ITEMS_SOLD() {
        return Order::where("status", "<>", "pending")
            ->get()
            ->sum(function($order) {
                return $order->quantity * $order->item->price;
            });
    }

    public static function GET_ORDERS_PLACED_THIS_WEEK() {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        return Order::whereBetween('date_order_placed', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
    }

}
