<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_model',
        'specification',
        'quantity',
        'touch_status',
        'discount',
        'user_id',
        'cat_id',
        'brand_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // public function suppliers()
    // {
    //     return $this->hasMany(Supplier::class);
    // }

    // public function supplier()
    // {
    //     return $this->belongsTo(Supplier::class);
    // }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}