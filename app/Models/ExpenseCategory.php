<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $table = 'expensecategories';

    protected $fillable = [
        'category_name',
        'images',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id');
    }
}