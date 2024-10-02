<?php

namespace App\Http\Controllers\Calculate;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Product;
use App\Models\Reserve;
use Illuminate\Http\Request;

class CalculateController extends Controller
{
    public function product()
    {
        $items = [
            'T-14 Core i5 10th Gen 16GB-Ram 256GB-SSD',
            'T14 (Touch) Ryzen-5pro Series-4650U 16GB-Ram 256GB-SSD',
            'T490s Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'T490s Core i5 8th Gen 16GB-Ram 256GB-SSD',
            'T490 Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'X1 Carbon Core i5 8GB-Ram 256GB-SSD',
            'x1 Yega-360(deg)Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'x1 Yega-360(deg)Core i5 8th Gen 16GB-Ram 256GB-SSD',
            'x1 Yega-360(deg)Core i7 8th Gen 16GB-Ram 512GB-SSD',
            '11E Selicon-3 4GB-Ram 128-SSD',
            'Asus Zenbook Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'Asus Vibobook Ryzen-5 Series-7520U 8GB-Ram 512SSD',
            'Asus Vibobook Core i5 12th Gen 8GB-Ram 512GB-SSD',
            'Surface2 Core i5 8th Gen 8GB-Ram 256-SSD',
            'Apple Macbook Air 2020 Core i5 16 GB-Ram 256GB-SSD',
            'Apple Macbook Air 2020 Core i5 8GB-Ram 512GB-SSD',
            'Apple Macbook Air 2020 M1 8GB-Ram 256GB-SSD',
            'Ipad 9th gen 256GB-SSD',
            'Hp Envy Core i7 12th Gen 16GB-Ram 512GB-SSD',
            'Hp Envy Core i5 13th Gen 8GB-Ram 512GB-SSD',
            'Hp EliteBook 840 G8 Core i7 11th Gen 16GB-Ram 512GB-SSD',
            'Hp EliteBook 840 G8 Core i5 11th Gen 16GB-Ram 512GB-SSD',
            'Hp EliteBook 840 G6 Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'Hp EliteBook 840 G7 Core i5 10th Gen 16GB-Ram 512GB-SSD',
            'Hp EliteBook 840 G7 Core i7 10th Gen 16GB-Ram 512GB-SSD',
            'T480S Core i7 8th Gen 8GB-Ram 256GB-SSD',
            'Hp EliteBook 850 G5 Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'Hp EliteBook 850(Touch) G5 Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'Hp EliteBook 850(Touch) G6 Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'HP 14 Core i3 11th Gen 8GB-Ram 256GB-SSD',
            'HP 15s Core i5 11th Gen 8GB-Ram 512GB-SSD',
            'HP 15s Core i5 13th Gen 8GB-Ram 512GB-SSD',
            'Hp EliteBook 820 G3 Core i5 6th Gen 8GB-Ram 256GB-SSD',
            'Hp EliteBook 840 G4 Core i5 7th Gen 8GB-Ram 256GB-SSD',
            'Hp EliteBook 850 G3 Core i5 6th Gen 8GB-Ram 256GB-SSD',
            'HP ProbookG7 Ryzen-5 Series-4500U 16GB-Ram 256GB-SSD',
            'HP Elitbook 735 G6 Ryzen-5 pro Series-4500U 16GB-Ram 256GB-SSD (2GB-DG)',
            'Hp EliteBook 850 G8 Core i7 11th Gen 16GB-Ram 512GB-SSD',
            'Hp Victus Ryzen-5 Series-5600H 8GB-Ram 1T-SSD',
            'HP Zbook (touch) Core-i5 8th Gen RAM-16 SSD-256',
            'Macbook M1 Air RAM-8 SSD-512',
            'Macbook M1 Pro RAM-8 SSD-512',
            'Macbook Air M2 RAM-8 SSD-256',
            'ViVi Laptop Handbag 14 Inc',
            'Minimalist Laptop Sleeve 14 Inc',
            'Apple Charger 96W',
            'Havit Wireless Mouse',
            'Laptop Stand S900',
            'Alpha 5 in 1 USB-C Hub',
            'Alpha 7 in 1 USB-C Hub',
            'MacBook Screen Protector 13.6',
            'TwinMOS SSD 256GB',
            'Lenovo SSD 256GB',
            'Mouse & Keyboard KIT',
            'T-14 Core i7 10th Gen 16GB-Ram 512GB-SSD',
            'T470s Core i7 6th Gen 8GB-Ram 256GB-SSD',
            'Apple Macbook Air 2023 M3 8GB-Ram 256GB-SSD',
            'Hp Elitbook 845 G7 Ryzen-5 Series-4650U 16GB-Ram 256GB-SSD',
            'T-14 Core i7 10th Gen 16GB-Ram 256GB-SSD',
            'L480 Core i5 8th Gen 8GB-Ram 256GB-SSD',
            'HP 15s Core i5 12th Gen 8GB-Ram 512GB-SSD',
        ];

        $products = Product::whereIn('product_model', $items)->get();

        $totalProductsCount = Product::count();

        $products = Product::with(['category', 'brand', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereIn('id', [1, 15]);  // Filter by category ID 1 (Laptop) and ID 5 (iPad)
            })
            ->get();
        $laptopQuantity = $products->where('cat_id', 1)->sum('quantity');
        $ipadQuantity = $products->where('cat_id', 15)->sum('quantity');

        
        $totalIn = Reserve::where('transaction_type', 'in')->sum('amount');
        $totalOut = Reserve::where('transaction_type', 'out')->sum('amount');
        $investmentTotalAmount = Investment::sum('amount');
        // Calculate the balance
        // $balance = $totalIn - $totalOut;
        $balance = ($totalIn+$totalOut);
        $netBalance=$balance - $investmentTotalAmount;

        if ($products->isNotEmpty()) {
            return response()->json([
                'message' => 'Products found',
                'products' => $products->map(function ($product) {
                    return [
                        'name' => $product->product_model,
                        'quantity' => $product->quantity
                    ];
                }),
                'total_products' => $totalProductsCount - 1,
                'total_laptop' => $laptopQuantity,
                'ipadQuantity' => $ipadQuantity,
                'total_in' => $totalIn,
                'total_out' => $totalOut,
                'balance' => $balance,
                'netbalance'=>$netBalance,
                'investmentTotalAmount'=> $investmentTotalAmount
            ]);
        } else {
            return response()->json([
                'message' => 'No products found'
            ], 404);
        }
    }
}
