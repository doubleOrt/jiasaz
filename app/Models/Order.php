<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

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

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeInDelivery($query)
    {
        return $query->where('status', 'in_delivery');
    }

    public function scopeDelivered($query)
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
            'shop_id' => $this->shop_id,
            'approved_or_rejected' => true,
            'date_of_response' => now(),
        ]);
        $response->save();

        $this->status = 'approved';
        $this->order_response_id = $response->id;
        $this->save();
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

    public function orderResponse()
    {
        return $this->belongsTo(OrderResponse::class, 'order_response_id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function reject($reason)
    {
        $response = new OrderResponse([
            'shop_id' => $this->shop_id,
            'approved_or_rejected' => false,
            'reason_for_rejection' => $reason,
            'date_of_response' => now(),
        ]);
        $response->save();

        $this->status = 'rejected';
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

    // ...
}