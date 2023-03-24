<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail {

    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    public static $ROLES = [
        "user" => "user",
        "shop_owner" => "shop_owner",
        "delivery_person" => "delivery_person",
        "admin" => "admin", 
    ];

    public static function GET_ROLES_ALLOWED_FROM_REGULAR_REGISTRATION() {
        $temp = self::$ROLES;
        unset($temp["admin"]);
        return $temp;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_no',
        'location_longitude',
        'location_latitude',
        'role',
        "profile_image_path",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the orders for the user.
     */
    public function orders() {
        return $this->hasMany(Order::class, "customer_id");
    }

    /**
     * Get the categories created by the user.
     */
    public function created_categories() {
        return $this->hasMany(Category::class, "added_by");
    }

    /**
     * Get the items by the user.
     */
    public function items() {
        return $this->hasMany(Item::class, "shop_id");
    }

    /**  
     * Get the orders made to a specific shop
    */
    public function shop_orders() {
        return $this->hasMany(Order::class, 'shop_id');
    }

    /**  
     * Get the deliveries by a specific user
    */
    public function deliveries() {
        return $this->hasMany(Delivery::class, 'delivery_person_id');
    }

}
