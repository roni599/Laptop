<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $table = 'cartitems';
    protected $fillable = [
        'item_no', 'quantity', 'price', 'status', 'cart_id', 'serial_id', 'payment_type_id'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function serial()
    {
        return $this->belongsTo(Serial::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
