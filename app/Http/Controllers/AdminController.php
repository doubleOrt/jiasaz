<?php

// No corresponding admin model exists but this is just an object where I intend to
// encapsulate some of the logic relating to admins.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{

    public static function GET_STATS_INFO() {
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

    // Returns an array containing 12 months along with the quantity of items sold
    // during that month and their total value, and the name of the month.
    public static function GET_LAST_TWELVE_MONTHS_DATA() {
        $last_twelve_months_data = [];
        $now = Carbon::now();
        for($i = 0; $i < 12; $i++) {
            $month = $i == 0 ? $now : $now->subMonth();
            $sold_in_month = Order::whereNotIn("status", ["pending", "rejected"])
            ->whereMonth("date_order_placed", $month->month)
            ->whereYear("date_order_placed", $month->year);
            $quantity = $sold_in_month->sum("quantity");
            $value = $sold_in_month->get()->sum(function($order) {
                return $order->quantity * $order->item->price;
            });

            $month_name = $month->format("F");
            $last_twelve_months_data[$i] = [
                "quantity_sold" => $quantity,
                "value_sold" => $value,
                "month_name" => $month_name,
            ];
            $now = $month;
        }
        return $last_twelve_months_data;
    }

    public static function GET_TOP_CATEGORIES($amount) {
        $top_categories = Order::where('status', '<>', 'pending')
        ->where('status', '<>', 'rejected')
        ->join('items', 'orders.item_id', '=', 'items.id')
        ->join('categories', 'items.category_id', '=', 'categories.id')
        ->select('categories.name', DB::raw('count(*) as total_orders'))
        ->groupBy('categories.id')
        ->orderByDesc('total_orders')
        ->limit($amount)
        ->get();
        $data = [];
        foreach($top_categories as $index => $top_category) {
            $data[$index] = [
                "category_name" => $top_category->name,
                "total_orders" => $top_category->total_orders,
            ];
        }
        return $data;
    }

    // returns the top {$amount} shops with the most orders. 
    public static function GET_TOP_SHOPS($amount) {
        $top_shops = DB::table('users')
        ->join('orders', 'users.id', '=', 'orders.shop_id')
        ->whereNotIn("orders.status", ["pending", "rejected"])
        ->select('users.id', 'users.first_name', "users.last_name", DB::raw('COUNT(*) as order_count'))
        ->groupBy('users.id', 'users.first_name', "users.last_name")
        ->orderByDesc('order_count')
        ->take($amount)
        ->get();
        $data = [];
        foreach($top_shops as $index => $top_shop) {
            $data[$index] = [
                "shop_id" => $top_shop->id,
                "first_name" => $top_shop->first_name,
                "last_name" => $top_shop->last_name,
                "total_orders" => $top_shop->order_count,
            ];
        }
        return $data;
    }

    // gets the percentage of users of each role
    public function GET_PERCENTAGE_OF_USERS() {

    }

    public function view_stats() { 
        return view("admin.view-stats", [
            "last_twelve_months_data" => SELF::GET_LAST_TWELVE_MONTHS_DATA(),
            "top_categories" => SELF::GET_TOP_CATEGORIES(5),
            "top_shops" => SELF::GET_TOP_SHOPS(5),
            "stats_info" => SELF::GET_STATS_INFO(),
        ]);
    }

    public function view_roles() {
        return view("admin.view-roles", [
            "roles" => Role::all(),
        ]);
    }

}
