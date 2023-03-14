<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'added_by',
        'style',
    ];

    protected $dates = [
        'date_added',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}