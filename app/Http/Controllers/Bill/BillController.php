<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Paymenttype;
use App\Models\Product;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function index()
    {
        $bill = Bill::all();
        return response()->json($bill);
    }
    public function store(Request $request)
    {

        //   return response()->json($request->all());
        $validatedData = $request->validate([
            'customerName' => 'required',
            'customerPhone' => 'required',
            'customerAddress' => 'nullable',
            'customerEmail' => 'nullable|email',
            'customerBirthday' => 'nullable|date',
            'customerNid' => 'nullable',
            'user_id' => 'required',
            'items' => 'required',
            'validInputs' => 'required',
            'cartId' => 'required|exists:carts,id',
            'totalsaleprice' => 'required',
            'validInputs2' => 'required',
        ]);


        // foreach ($validatedData['items'] as $item) {
        //     // Find the product using the product_id in the stock field
        //     $product = Product::find($item['stock']['product_id']);

        //     if ($product) {
        //         // Decrement the product quantity
        //         $product->decrement('quantity', $item['quantity']);
        //     }

        //     // Find the CartItem using serial_id
        //     CartItem::where('serial_id', $item['id'])
        //         ->where('cart_id', $validatedData['cartId'])
        //         ->update([
        //             'quantity' => $item['quantity'],
        //             'unit_price' => $item['stock']['buying_price'],
        //             'sold_price' => $item['stock']['selling_price'],
        //             'profit' => $item['stock']['selling_price'] - $item['stock']['buying_price'],
        //             'total_profit' => ($item['stock']['selling_price'] * $item['quantity']) - ($item['stock']['buying_price'] * $item['quantity']),
        //         ]);
        // }

        foreach ($validatedData['items'] as $item) {
            // Find the product using the product_id in the stock field
            $product = Product::find($item['stock']['product_id']);

            if ($product) {
                // Check if the requested quantity is greater than available stock
                if ($item['quantity'] > $product->quantity) {
                    return response()->json([
                        'message' => 'Order quantity is greater than available stock for product: ' . $product->name,
                        'available_stock' => $product->quantity,
                        'requested_quantity' => $item['quantity']
                    ], 400);
                }

                // Decrement the product quantity by the requested quantity
                $product->decrement('quantity', $item['quantity']);
            }

            // Find the CartItem using serial_id and update its details
            CartItem::where('serial_id', $item['id'])
                ->where('cart_id', $validatedData['cartId'])
                ->update([
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['stock']['buying_price'],
                    'sold_price' => $item['stock']['selling_price'],
                    'profit' => $item['stock']['selling_price'] - $item['stock']['buying_price'],
                    'total_profit' => ($item['stock']['selling_price'] * $item['quantity']) - ($item['stock']['buying_price'] * $item['quantity']),
                ]);
        }


        $customer = Customer::create([
            'customer_name' => $validatedData['customerName'],
            'phone' => $validatedData['customerPhone'],
            'address' => $validatedData['customerAddress'],
            'email' => $validatedData['customerEmail'],
            'dob' => $validatedData['customerBirthday'] ?? Carbon::today(),
            'nid' => $validatedData['customerNid'],
            'user_id' => $validatedData['user_id']
        ]);

        $cart = Cart::find($validatedData['cartId']);

        if ($cart) {
            $cart->customer_id = $customer->id;
            $cart->save();
        } else {
            return response()->json(['error' => 'Cart not found'], 404);
        }
        $bill = new Bill();
        $bill->bill_id = 'LP' . substr((string) Str::uuid(), 0, 5);
        $bill->total_price = $validatedData['totalsaleprice'];
        $bill->customer_id = $customer->id;
        $bill->user_id = $validatedData['user_id'];
        $bill->cart_id = $cart->id;
        $bill->save();

        foreach ($validatedData['validInputs'] as $key => $paymentTypeId) {
            // Check if a corresponding amount exists in validInputs2
            if (isset($validatedData['validInputs2'][$key])) {
                // Create a Reserve entry with payment_type_id and amount
                Reserve::create([
                    'bill_id' => $bill->id, // Associate with the single bill ID
                    'payment_type_id' => $paymentTypeId, // Value from validInputs (payment_type_id)
                    'amount' => $validatedData['validInputs2'][$key], // Value from validInputs2 (amount as a string)
                    'transaction_type' => 'in', // Default value for transaction type
                    'status' => '0', // Default value for status
                    'user_id' => $request->user_id
                ]);
            }
        }

        $entriesToDelete = CartItem::whereNull('sold_price')   // Check if sold_price is NULL
            ->whereNull('profit')                              // Check if profit is NULL
            ->delete();
        $entriesToDeleteCart = Cart::whereNull('customer_id')->delete();
        return response()->json($bill->id);
    }

    public function billGenerate($id)
    {

        $bill = Bill::with(['cart.cartItems.serial.stock.product', 'customer'])->find($id);
        $payment = Reserve::with('paymenttype')->where('bill_id', $id)->get();
        return response()->json([
            'bill' => $bill,
            'payment' => $payment
        ]);
    }
    public function billtable()
    {
        // $bills = Bill::with([
        //     'cart.cartitems.serial.stock.product.brand',
        //     'cart.cartitems.serial.stock.product.category',
        //     'user',
        //     'customer'
        // ])->get();
        $bills = Bill::with([
            'cart.cartitems.serial.stock.product.brand',
            'cart.cartitems.serial.stock.product.category',
            'user',
            'customer',
            'reserves.paymenttype' // Load the reserves and their related payment type
        ])
            ->get();
        // $bills = Bill::with([
        //     'cart.cartitems.serial.stock.product.brand',
        //     'cart.cartitems.serial.stock.product.category',
        //     'user',
        //     'customer',
        //     'paymenttype' // Load the related payment data
        // ])
        // ->whereNotNull('bill_id') // Filter reserves where bill_id is not null
        // ->get();
        return response()->json($bills);
    }
    public function delete($id)
    {
        $bill = Bill::with([
            'cart.cartitems.serial.stock.product',
            'reserves.paymenttype'
        ])->where('id', $id)->firstOrFail();
        foreach ($bill->cart->cartitems as $cartItem) {
            $product = $cartItem->serial->stock->product;
            $newProductQuantity = $product->quantity + $cartItem->quantity;
            $product->quantity = max($newProductQuantity, 0);
            $product->save();
        }
        foreach ($bill->reserves as $reserve) {
            Reserve::create([
                'bill_id' => $bill->id,
                'payment_type_id' => $reserve->payment_type_id,
                'amount' => $reserve->amount,
                'transaction_type' => 'out',
                'status' => '0',
                'user_id' => $reserve->user_id
            ]);
        }
        $bill->cart->delete();
        $bill->delete();
        return response()->json(['message' => 'Bill, cart, and cart items deleted successfully. Product quantities restored!']);
    }
    public function bill_edit_reserve_delete($id)
    {
        $reserve = Reserve::find($id);
        return response()->json($reserve);
    }
    public function billUpdate(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'products.*.product_name' => 'required|string',
            'products.*.sold_price' => 'required|numeric',
            'reserves.*.payment_type' => 'required|string',
            'reserves.*.amount' => 'required|numeric'
        ]);
        $bill = Bill::with([
            'cart.cartitems.serial.stock.product',
            'reserves.paymenttype'
        ])->where('cart_id', $request->id)->firstOrFail();
        $customer_id = $bill->cart->customer->id;
        $customer = Customer::findOrFail($customer_id);
        $customer->customer_name = $request->customer_name;
        $customer->save();

        $productIds = [];
        $cartItemsIds = [];
        $totalPrice = 0;

        if ($bill->cart && $bill->cart->cartitems) {
            foreach ($bill->cart->cartitems as $cartItem) {
                $cartItemsIds[] = $cartItem->id;
                if (isset($cartItem->serial->stock->product->id)) {
                    $productIds[] = $cartItem->serial->stock->product->id;
                }
            }
        }
        foreach ($productIds as $index => $productId) {
            if (isset($request->products[$index])) {
                $product = Product::find($productId);
                if ($product) {
                    $product->product_model = $request->products[$index]['product_name'];
                    $product->save();
                }
            }
        }

        foreach ($cartItemsIds as $index => $productId) {
            if (isset($request->products[$index]['sold_price'])) {
                $product = CartItem::find($productId);
                $bill_id = Bill::findOrFail($bill->id);
                if ($product) {
                    $soldPrice = $request->products[$index]['sold_price'];
                    $unitPrice = $product->unit_price;
                    $product->sold_price = $soldPrice;
                    $product->profit = $soldPrice - $unitPrice;
                    $product->total_profit = $soldPrice - $unitPrice;
                    $totalPrice += $soldPrice;
                    $product->save();
                }
            }
        }
        $bill->total_price = $totalPrice;
        $bill->save();

        $reserves = $request->input('reserves');

        foreach ($reserves as $reserve) {
            Reserve::where('id', $reserve['id'])->update([
                'amount' => $reserve['amount']
            ]);
        }
        return response()->json(['message' => 'Bills updated successfully']);
    }
}
