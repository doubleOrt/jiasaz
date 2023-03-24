<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Exception;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('temp-auth.create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $attributes = $request->validate([
            "first_name" => ["required", "string", "min:2", "max:255"],
            "last_name" => ["required", "string", "min:2", "max:255"],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            "phone_no" => ["required", "string", "unique:users"],
            "location" => ["required"],
            "role" => ["required", RULE::in(USER::GET_ROLES_ALLOWED_FROM_REGULAR_REGISTRATION())],
        ]);

        $position_coords = explode(",", $attributes["location"]);
        $attributes["location_latitude"] = $position_coords[0]; 
        $attributes["location_longitude"] = $position_coords[1]; 
        $attributes["password"] = Hash::make($attributes["password"]);
        $attributes["phone_no"] = str_replace("-", "", $attributes["phone_no"]);

        unset($attributes["location"]);

        $user = User::create($attributes);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function admin_delete_user(Request $request) {
        $logged_in_user = Auth()->user();
        if (!$logged_in_user->can("admin delete user accounts")) {
            throw new Exception("You don't have the right permissions!");
        }
        $attributes = $request->validate([
            "user_id" => "required|exists:users,id",
        ]);
        $user = User::find($attributes["user_id"]);
        $user->delete();
        return "User deleted successfully!";
    }

}
