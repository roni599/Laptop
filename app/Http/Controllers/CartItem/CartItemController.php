<?php

namespace App\Http\Controllers\CartItem;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index(){
        $cartitems=CartItem::all();
        return response()->json($cartitems);
    }
}
