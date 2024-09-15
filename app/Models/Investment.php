<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paymenttype_id',
        'In_name',
        'Amount',
        'date',
        'status'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with PaymentType
    public function paymenttype()
    {
        return $this->belongsTo(PaymentType::class);
    }
    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }
}