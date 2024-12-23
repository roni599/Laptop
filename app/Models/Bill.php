<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'bills';

    // The attributes that are mass assignable.
    protected $fillable = [
        'bill_id',
        'total_price',
        // 'quantity',
        // 'price',
        'status',
        'customer_id',
        'user_id',
        'cart_id'
    ];

    // Define relationships if necessary
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function paymenttype()
    {
        return $this->belongsTo(Paymenttype::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serial()
    {
        return $this->belongsTo(Serial::class);
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }
    // public function reserve()
    // {
    //     return $this->hasOne(Reserve::class, 'bill_id'); // Assuming `bill_id` is the foreign key in the Reserve table
    // }
}
