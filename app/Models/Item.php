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