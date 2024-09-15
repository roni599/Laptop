<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'cat_name',
        'cat_img',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }
}