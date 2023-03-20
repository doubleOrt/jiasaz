<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    public $timestamps = false;
    
    public static $STATUS_PENDING = "pending";
    public static $STATUS_APPROVED = "approved";
    public static $STATUS_REJECTED = "rejected";
    public static $STATUS_IN_DELIVERY = "in_delivery";
    public static $STATUS_DELIVERED = "delivered";

    protected $fillable = [
        'item_id',
        'shop_id',
        'customer_id',
        'order_response_id',
        'delivery_id',
        'status',
        'date_order_placed',
        'quantity'
    ];

    protected $dates = [
        'date_order_placed'
    ];

    public static function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public static function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public static function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public static function scopeInDelivery($query)
    {
        return $query->where('status', 'in_delivery');
    }

    public static function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isInDelivery()
    {
        return $this->status === 'in_delivery';
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function approve()
    {
        $response = new OrderResponse([
            "order_id" => $this->id,
            "shop_id" => $this->shop_id,
            "approved_or_rejected" => true,
            "date_of_response" => now(),
        ]);
        $response->save();

        $this->status = self::$STATUS_APPROVED;
        $this->order_response_id = $response->id;
        $this->save();

        $item = $this->item;
        $item->amount_currently_in_stock -= $this->quantity;
        $item->save();
    }


    public function assignDelivery($deliveryId)
    {
        $this->delivery_id = $deliveryId;
        $this->status = 'in_delivery';
        $this->save();
    }

    public function completeDelivery($itemCondition)
    {
        $this->status = 'delivered';
        $this->delivery->item_condition_after_delivery = $itemCondition;
        $this->delivery->date_delivered = now();
        $this->delivery->save();
        $this->save();
    }

    public function canBeApprovedBy(User $user)
    {
        return $this->isPending() && $this->shop_id === $user->id;
    }

    public function canBeRejectedBy(User $user)
    {
        return $this->isPending() && $this->shop_id === $user->id;
    }

    public function canBeAssignedDeliveryBy(User $user)
    {
        return $this->isApproved() && $this->shop_id === $user->id;
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shop()
    {
        return $this->belongsTo(User::class, 'shop_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function order_responses()
    {
        return $this->hasMany(OrderResponse::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function reject($reason)
    {
        $response = new OrderResponse([
            "order_id" => $this->id,
            "shop_id" => $this->shop_id,
            "approved_or_rejected" => false,
            "reason_for_rejection" => $reason,
            "date_of_response" => now(),
        ]);
        $response->save();

        $this->status = self::$STATUS_REJECTED;
        $this->order_response_id = $response->id;
        $this->save();
    }

    public function setInDelivery($delivery_id)
    {
        $this->status = 'in_delivery';
        $this->delivery_id = $delivery_id;
        $this->save();
    }

    public function setDelivered()
    {
        $this->status = 'delivered';
        $this->save();
    }

}