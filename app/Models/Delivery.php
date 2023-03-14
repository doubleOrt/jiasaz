<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'orderId',
        'delivery_person_id',
        'date_delivery_accepted',
        'date_delivered',
        'item_condition_after_delivery',
        'delivery_fee'
    ];

    protected $dates = [
        'date_delivery_accepted',
        'date_delivered'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId');
    }

    public function deliveryPerson()
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