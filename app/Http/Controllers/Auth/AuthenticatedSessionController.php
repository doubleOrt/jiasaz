<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{

    // Define the directory where uploaded images will be saved
    private static function GET_PROFILE_IMAGE_UPLOAD_DIRECTORY() {
        return storage_path() . "\\app\\public\\profile_images\\";
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    { 
        if (Auth::check()) {
            $user = Auth()->user();
            if ($user->hasRole("customer")) {
                return view("index", [
                    "first_ten_items" => Item::take(10)->get()
                ]);
            } else if ($user->hasRole("shop_owner")) {
                return view("shop.orders", [
                    "orders" => $user->shopOrders->where("status", Order::$STATUS_PENDING)->sortByDesc("id"),
                ]);
            } else if ($user->hasRole("delivery_person")) {
                return redirect()->route("deliveries.show-available");
            } else if ($user->hasRole("admin")) {
                $dashboard_data = AdminController::GET_DASHBOARD_DATA();
                return view("admin.dashboard", [
                    "dashboard_data" => $dashboard_data,
                ]);
            }
        }
        return view("temp-auth.login");
    }


    public function show_user_profile(User $user) {
        $data = [
            "user" => $user,
            "orders" => $user->orders,
        ];

        if ($user->role == User::$ROLES["shop_owner"]) {
            $data["items"] = $user->items;
        }

        return view("profile.profile", $data);
    }

    public function update(Request $request, User $user) {

        $attributes = $request->all();
        $validator = Validator::make($attributes, [
            "first_name" => [
                "required",
                "string",
                "min:2",
                "max:255",
            ],
            "last_name" => [
                "required",
                "string",
                "min:2",
                "max:255",
            ],
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                Rule::unique('users')->ignore($user->id),
            ],
            "phone_no" => [
                "required",
                "string",
                Rule::unique('users')->ignore($user->id),
            ],
            "profile_image" => ["image"],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());   
        }

        if (!isset($user)) {
            $user = auth()->user();
        } 

        $user["first_name"] = $attributes["first_name"];
        $user["last_name"] = $attributes["last_name"];
        $user["email"] = $attributes["email"];
        // Convert to correct format for database (remove "-"s between the numbers)
        $attributes["phone_no"] = str_replace("-", "", $attributes["phone_no"]);
        $user["phone_no"] = $attributes["phone_no"];


        if(array_key_exists("profile_image", $attributes)) {
            $user["profile_image_path"] = $this->save_profile_image($attributes["profile_image"]);
        }

        $user->save();

        return redirect()->back()->with("success", "Profile updated successfully!");    
    }

    public function save_profile_image($imageInput) {

        $image = Image::make($imageInput);
        // Create a unique filename for the uploaded image
        $file_name = Str::uuid();
		$path = self::GET_PROFILE_IMAGE_UPLOAD_DIRECTORY() . $file_name . ".jpg";
        if ( $image->width() > $image->height() ) { // Landscape
            $image->widen(1200)
                ->save($path);
        } else { // Portrait
            $image->heighten(900)
                ->save($path);
        }
        return "/storage/profile_images/" . $file_name . ".jpg";
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
