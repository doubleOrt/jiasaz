<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{

    public $timestamps = false;

    protected $fillable = [
        "shop_id",
        'order_id',
        'delivery_person_id',
        'date_offer_made',
        'date_offer_replied_to',
        'offer_reply',
        'date_delivered',
        'item_condition_after_delivery',
        'delivery_fee'
    ];

    protected $dates = [
        'date_offer_made',
        "date_offer_replied_to",
        'date_delivered',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function shop()
    {
        return $this->belongsTo(User::class, 'shop_id');
    }

    public function delivery_person()
    {
        return $this->belongsTo(User::class, 'delivery_person_id');
    }

    public function setDelivered()
    {
        $this->date_delivered = now();
        $this->save();
    }

    public function isDelivered()
    {
        return !is_null($this->date_delivered);
    }
}