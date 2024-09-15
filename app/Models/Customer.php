<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'address',
        'email',
        'dob',
        'nid',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Customer.php
    // public function bills()
    // {
    //     return $this->hasMany(Bill::class);
    // }
    public function bills()
    {
        return $this->hasMany(Bill::class)->distinct('paymenttype_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
