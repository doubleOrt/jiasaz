<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;



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


require __DIR__.'/auth.php';

Route::middleware(["auth"])->group(function() {
    
    Route::get('/', [AuthenticatedSessionController::class, "create"])->name("main_page");

    Route::get('/category/{category}', function(Category $category) {
        return view("category", [
            "category" => $category,
            "items" => $category->items()->get(),
        ]);
    });
    
    Route::get('/profile/{user}', [AuthenticatedSessionController::class, "show_user_profile"]);

    Route::get("/user-items/{user}", [ItemController::class, "show_items_by_user"])
        ->middleware(["permission:see shop items"])
        ->name("items.show-by-user");

    Route::get("/search", [ItemController::class, "search"])->name("items.search");


    Route::middleware(["role:admin|customer"])->group(function(){
        Route::post('/order', [OrderController::class, "store"]);
        Route::post('/cancel-order', [OrderController::class, "cancel"]);
        Route::get('/orders/{user_id}', [OrderController::class, 'show_all_from_user'])->name('orders.show');
    });

    Route::middleware(["role:admin|shop_owner"])->group(function(){
        Route::get("/shop-orders/{shop_id}", [OrderController::class, "show_all_to_shop"])
        ->name("orders.shop");
        
        Route::post('/approve-order', [OrderController::class, "approve"]);
        Route::post('/reject-order', [OrderController::class, "reject"]);

        Route::get("/my-shop-orders", function(){
            $user = auth()->user();
            if ($user->role == User::$ROLES["shop_owner"] || $user->role == User::$ROLES["admin"]) {
                return redirect()->route("orders.shop", $user->id);
            }
        });

        Route::get("/add-item", [ItemController::class, "create"]);
        Route::post("/add-item", [ItemController::class, "store"]);

        Route::post("/approve-delivery-offer", [DeliveryController::class, "approve_offer"]);
        Route::post("/reject-delivery-offer", [DeliveryController::class, "reject_offer"]);
        Route::get("/delivery-requests", [DeliveryController::class, "show_requests_to_shop"]);
        Route::get("/show-shop-deliveries", [DeliveryController::class, "show_shop_deliveries"]);
        
        Route::get("/my-items", function() {
            $user = auth()->user();
            if ($user->role == User::$ROLES["shop_owner"]) {
                return redirect()->route("items.show-by-user", $user->id);
            }
        });

    });

    Route::middleware(["role:admin|delivery_person"])->group(function() {
        Route::get("/show-available-deliveries", [DeliveryController::class, "show_available_deliveries"])
        ->name("deliveries.show-available");
        Route::get("/show-previous-deliveries/{user_id}", [DeliveryController::class, "show_previous_deliveries"]);
        Route::get("/show-current-deliveries", [DeliveryController::class, "show_current_deliveries"])->name("deliveries.show-current");
        
        Route::post("/make-delivery-offer", [DeliveryController::class, "make_delivery_offer"]);
        Route::post("/set-delivery-as-complete", [DeliveryController::class, "set_delivery_as_complete"]);
    });

    Route::post("/update-account", function(Request $request) {
        $authController = new AuthenticatedSessionController;
        $user = auth()->user();
        if ($user->hasRole("admin") || $user->can("update user accounts")) {
            if (array_key_exists("user_id", $request)) {
                $user = User::find($request["user_id"]);
            }
            return $authController->update($request, $user);
        } else {
            return $authController->update($request, $user);
        }
    })->name("account.update");

    
    Route::get("/admin-add-category", [CategoryController::class, "create_add_category"])
        ->middleware(["permission:add item categories"]);

    Route::post("/admin-add-category", [CategoryController::class, "store"])
        ->middleware(["permission:add item categories"]);
            
    Route::get("/admin-view-categories", [CategoryController::class, "create_admin_view_categories"])
    ->middleware(["permission:admin view categories"]);

    Route::post("/admin-update-category", [CategoryController::class, "update"])
    ->middleware(["permission:admin update categories"]);

    Route::get("/admin-view-items", [ItemController::class, "create_admin_view_items"])
    ->middleware(["permission:admin view items"]);
    
    Route::post("/admin-update-item", [ItemController::class, "admin_update"])
    ->middleware(["permission:admin update items"]);

    Route::post("/admin-delete-item", [ItemController::class, "admin_delete_item"])
    ->middleware(["permission:admin delete items"]);

    Route::get("/admin-view-users", [AuthenticatedSessionController::class, "create_admin_view_users"])
    ->middleware(["permission:admin view users"]);

    Route::post("/admin-update-user-account", [AuthenticatedSessionController::class, "admin_update_user"])
    ->middleware(["permission:update user accounts"]);
    
    Route::post("/admin-delete-user", [RegisteredUserController::class, "admin_delete_user"])
    ->middleware(["permission:admin delete user accounts"]);

    Route::get("/admin-view-stats", [AdminController::class, "view_stats"])
    ->middleware(["permission:admin view stats"]);

    Route::get("/admin-view-orders", [OrderController::class, "admin_view_orders"])
    ->middleware(["permission:admin view orders"]);

    Route::get("/admin-view-roles", [AdminController::class, "view_roles"])
    ->middleware(["permission:admin view roles"]);

});
