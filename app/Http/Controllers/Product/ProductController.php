<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category', 'brand', 'user'])->get();
        return response($product);
    }
    public function store(Request $request)
    {

        $request->validate([
            'product_model' => 'required|string|max:255',
            'specification' => 'required|string',
            // 'quantity' => 'required|integer|min:0',
            'touch_status' => 'required|string',
            // 'discount' => 'nullable|numeric|min:0|max:10000',
            'user_id' => 'required|exists:users,id',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);
        $product = new Product();
        $product->product_model = $request->product_model;
        $product->specification = $request->specification;
        // $product->quantity = $request->quantity;
        $product->touch_status = $request->touch_status;
        // $product->discount = $request->discount;
        $product->user_id = $request->user_id;
        $product->cat_id = $request->cat_id;
        $product->brand_id = $request->brand_id;
        $product->save();
        return response()->json(['message' => 'Product created successfully']);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
    public function ProductsUpdate(Request $request)
    {

        $request->validate([
            'product_model' => 'required|string|max:255',
            'specification' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'touch_status' => 'required|string',
            'discount' => 'nullable|numeric|min:0|max:10000',
            'user_id' => 'required|exists:users,id',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update($request->only([
            'product_model',
            'specification',
            'quantity',
            'touch_status',
            'discount',
            'user_id',
            'cat_id',
            'brand_id'
        ]));
        $product->save();

        return response()->json(['message' => 'Product updated successfully']);
    }
    public function stocks_update(Request $request)
    {
        $request->validate([
            'product_quantity' => 'required|integer',
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->product_quantity = $request->product_quantity;
        $product->save();
        return response()->json(['message' => 'Stocks updated successfully']);
    }
}
