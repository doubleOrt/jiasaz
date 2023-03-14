<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create() {
        return view("register.create");
    }

    public function store() {

        $attributes = request()->validate([
            "first_name" => ["required", "min:2", "max:30"],
            "last_name" => ["required", "min:2", "max:30"],
            "email_address" => ["required", "email"],
            "phone_no" => ["required"],
            "password" => ["required", "min:8", "max:30"],
            "location" => ["required"]
        ]);

        $position_coords = explode(",", $attributes["location"]);
        $attributes["location_latitude"] = $position_coords[0]; 
        $attributes["location_longitude"] = $position_coords[1]; 
        $attributes["password"] = bcrypt($attributes["password"]);
        $attributes["phone_no"] = str_replace("-", "", $attributes["phone_no"]);
        $attributes["role"] = "user";

        unset($attributes["location"]);

        User::create($attributes);

        return redirect("/");
    }
}
