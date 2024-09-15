<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    use HasFactory;
    protected $fillable = ['serial_no', 'color', 'image', 'status', 'return_status', 'stock_id', 'barcode_image'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
