<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'shop_id',
        'category_id',
        'title',
        'price',
        'description',
        'original_amount',
        'amount_currently_in_stock',
        "image_path",
    ];

    public static function boot() {
        parent::boot();

        // Whenever an item is deleted, we need to run this to delete all related rows in another tables.
        static::deleting(function($item) {
            $item_orders = $item->orders;
            foreach ($item_orders as $order) {
                $order_responses = $order->order_responses;
                foreach($order_responses as $order_response) {
                    $order_response->delete();
                }
                $order_deliveries = $order->deliveries;
                foreach($order_deliveries as $order_delivery) {
                    $order_delivery->delete();
                }
                $order->delete();
            }
       });
    }

    // Relationships
    public function shop()
    {
        return $this->belongsTo(User::class, 'shop_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Methods
    public function addToStock($quantity)
    {
        $this->amount_currently_in_stock += $quantity;
        $this->save();
    }

    public function removeFromStock($quantity)
    {
        $this->amount_currently_in_stock -= $quantity;
        $this->save();
    }
    
    public function isAvailable($quantity)
    {
        return $this->amount_currently_in_stock >= $quantity;
    }

    public function sell($quantity)
    {
        if ($this->isAvailable($quantity)) {
            $this->removeFromStock($quantity);
            return true;
        }
        return false;
    }
}