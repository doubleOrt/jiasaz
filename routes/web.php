<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
Route::get("/login", function() {
    return view("login");
});

Route::get("/register", [RegisterController::class, "create"]);
Route::post("/register", [RegisterController::class, "store"]);

Route::get('/insert_row', function () {
    $user = new User;
    $user->first_name = "Toros";
    $user->last_name = "Sabah";
    $user->email_address = "torossabahyahya@gmail.com";
    $user->password = "hello";
    $user->phone_no = "7517833058";
    $user->location_latitude = 36.699913;
    $user->location_longitude = 44.533497;
    $user->role = "admin";
    $user->save();

    $customer = new User;
    $customer->first_name = "John";
    $customer->last_name = "Doe";
    $customer->email_address = "fantasybl8@gmail.com";
    $customer->password = "hello";
    $customer->phone_no = "7504708749";
    $customer->location_latitude = 36.125145;
    $customer->location_longitude = 44.025009;
    $customer->role = "user";
    $customer->save();

    $shop = new User;
    $shop->first_name = "Rich";
    $shop->last_name = "Guy";
    $shop->email_address = "fantasypl8@gmail.com";
    $shop->password = "hello";
    $shop->phone_no = "7504779494";
    $shop->location_latitude = 36.208947;
    $shop->location_longitude = 44.010487;
    $shop->role = "shop";
    $shop->save();

    $delivery = new User;
    $delivery->first_name = "Ali";
    $delivery->last_name = "Ramadani";
    $delivery->email_address = "abcdef@gmail.com";
    $delivery->password = "hello";
    $delivery->phone_no = "7509412881";
    $delivery->location_latitude = 36.139635;
    $delivery->location_longitude = 44.042951;
    $delivery->role = "delivery_person";
    $delivery->save();

    $category = new Category;
    $category->name = "Mobile Phones";
    $category->description = "Mobile Phones Description";
    $category->added_by = 1;
    $category->style = "crimson";
    $category->save();

    $item = new Item;
    $item->shop_id = 3;
    $item->category_id = 1;
    $item->title = "Samsung Galaxy S8";
    $item->price = 999.99;
    $item->description = "New Samsung Galaxy S8 Phone, get one now!";
    $item->original_amount = 1000;
    $item->amount_currently_in_stock;
    $item->save();


    dd("Row added successfully!");
});
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [AuthenticatedSessionController::class, "create"])->name("main_page");

Route::get('/category/{category}', function(Category $category) {
    return view("category", [
        "category" => $category,
        "items" => $category->items()->get(),
    ]);
});

Route::get('/profile/{user}', [AuthenticatedSessionController::class, "show_user_profile"]);

Route::post('/order', [OrderController::class, "store"]);

Route::post('/cancel-order', [OrderController::class, "cancel"]);

Route::post('/approve-order', [OrderController::class, "approve"]);
Route::post('/reject-order', [OrderController::class, "reject"]);

Route::get('/orders', [OrderController::class, 'show_all_from_user'])->name('orders.show');

Route::get("/shop-orders/{shop_id}", [OrderController::class, "show_all_to_shop"])->name("orders.shop");

Route::get("/search", [ItemController::class, "search"])->name("items.search");

Route::get("/user-items/{user}", [ItemController::class, "show_items_by_user"])->name("items.show-by-user");

Route::get("/my-items", function() {
    $user = auth()->user();
    if ($user->role == User::$ROLES["shop_owner"]) {
        return redirect()->route("items.show-by-user", $user->id);
    }
});

Route::get("/my-shop-orders", function(){
    $user = auth()->user();
    if ($user->role == User::$ROLES["shop_owner"] || $user->role == User::$ROLES["admin"]) {
        return redirect()->route("orders.shop", $user->id);
    }
});

Route::get("/add-item", [ItemController::class, "create"]);

Route::get("/delivery-requests", [DeliveryController::class, "show_requests_to_shop"]);

Route::get("/show-shop-deliveries", [DeliveryController::class, "show_shop_deliveries"]);

Route::post("/add-item", [ItemController::class, "store"]);

Route::post("/approve-delivery-offer", [DeliveryController::class, "approve_offer"]);
Route::post("/reject-delivery-offer", [DeliveryController::class, "reject_offer"]);

Route::get("/show-available-deliveries", [DeliveryController::class, "show_available_deliveries"])->name("deliveries.show-available");

Route::post("/make-delivery-offer", [DeliveryController::class, "make_delivery_offer"]);