<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';

    protected $fillable = [
        'expenser_id',
        'expense_desc',
        'amount',
        'cost_type',
        'date',
        'status',
        'receipt_img',
        'expense_category_id',
        'user_id',
        'payment_type_id'
    ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
    // public function expenser()
    // {
    //     return $this->belongsTo(User::class, 'expense_id');
    // }
    // public function reserves()
    // {
    //     return $this->hasMany(Reserve::class, 'expense_id');
    // }



//     public function expenser()
// {
//     return $this->belongsTo(User::class, 'expenser_id');
// }

public function reserves()
{
    return $this->hasMany(Reserve::class, 'expense_id');
}
public function expenser()
{
    return $this->belongsTo(User::class, 'expenser_id');
}

}