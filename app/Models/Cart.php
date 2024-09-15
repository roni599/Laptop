<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';

    // Define the fillable attributes
    protected $fillable = [
        'status', 'customer_id'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }


    // Define the relationship with the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
