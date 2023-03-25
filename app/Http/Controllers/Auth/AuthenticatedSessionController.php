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
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use Exception;

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
                    "orders" => $user->shop_orders->where("status", Order::$STATUS_PENDING)->sortByDesc("id"),
                ]);
            } else if ($user->hasRole("delivery_person")) {
                return redirect()->route("deliveries.show-available");
            } else if ($user->hasRole("admin")) {
                $stats_info = AdminController::GET_STATS_INFO();
                return view("admin.dashboard", [
                    "stats_info" => $stats_info,
                ]);
            }
        }
        return view("temp-auth.login");
    }

    public function create_admin_view_users() {
        return view("admin.view-users", [
            "users" => User::with("orders", "shop_orders", "items")->get(),
        ]);
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
                "string",
                "min:2",
                "max:255",
            ],
            "last_name" => [
                "string",
                "min:2",
                "max:255",
            ],
            "email" => [
                "string",
                "email",
                "max:255",
                Rule::unique('users')->ignore($user->id),
            ],
            "phone_no" => [
                "string",
                Rule::unique('users')->ignore($user->id),
            ],
            "profile_image" => ["image"],
            "email_verified" => ["boolean"],
            "password" => [Rules\Password::defaults()],
            "location_latitude" => ["numeric", "regex:/^-?([0-8]?[0-9]|90)(\.[0-9]{1,10})$/"],
            "location_longitude" => ["numeric", "regex:/^-?([0-9]{1,2}|1[0-7][0-9]|180)(\.[0-9]{1,10})$/"], 
        ]);

        if($validator->fails()) {
            throw new Exception('Validation of provided data failed');
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


        if (array_key_exists("profile_image", $attributes)) {
            $user["profile_image_path"] = $this->save_profile_image($attributes["profile_image"]);
        }  

        if (array_key_exists("password", $attributes)) {
            $user["password"] = Hash::make($attributes["password"]);
        } 
        
        if (array_key_exists("location_latitude", $attributes) && array_key_exists("location_longitude", $attributes)) {
            $user["location_latitude"] = $attributes["location_latitude"];
            $user["location_longitude"] = $attributes["location_longitude"];
        }  

        $signed_in_user = auth()->user();
        if ($signed_in_user->can("update user accounts")) {
            if (array_key_exists("email_verified", $attributes)) {
                if ($attributes["email_verified"] == true) {
                    $user["email_verified_at"] = Carbon::now();
                } else {
                    $user["email_verified_at"] = null;
                }   
            }
        }

        $user->save();

        return redirect()->back()->with("success", "Profile updated successfully!");    
    }

    public function admin_update_user(Request $request) {
        $user_id = $request->get("user_id");
        if ($user_id) {
            $user = User::find($user_id);
            /* We have a validation rule that expects "email_verified" to be boolean, so we have to 
            * cast this from string to boolean here.
            */
            if ($request->has("email_verified")) {
               $request->merge(['email_verified' => $request->boolean("email_verified")]);
            }
            $this->update($request, $user);
        }
        return "User account updated successfully!";
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
