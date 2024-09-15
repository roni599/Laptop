<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymenttype extends Model
{
    use HasFactory;
    protected $fillable = [
        'pt_name',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'paymenttype_id');
    }
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'payment_type_id');
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
