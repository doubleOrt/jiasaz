<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shop_id',
        'approved_or_rejected',
        'reason_for_rejection'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shop()
    {
        return $this->belongsTo(User::class);
    }
}