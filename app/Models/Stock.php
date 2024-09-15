<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock_date',
        'buying_price',
        'selling_price',
        'stock_quantity',
        'status',
        'user_id',
        'product_id',
        'paymenttype_id',
        'supplier_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function serials()
    {
        return $this->hasMany(Serial::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymenttype_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}