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
        return response()->json($bill->id);
    }

    public function billGenerate($id)
    {
        // Fetch the bill along with related cart, serial, stock, product, and customer information
        $bill = Bill::with(['cart.cartItems.serial.stock.product', 'customer'])->find($id);

        // Fetch the payment details related to the reserve and payment type
        // $payment = Reserve::with(['paymenttype'])->find($id);
        $payment = Reserve::with('paymenttype')->where('bill_id', $id)->get();

        // Return both the bill and payment data in the response
        return response()->json([
            'bill' => $bill,
            'payment' => $payment
        ]);
    }
    public function billtable()
    {
        $bills = Bill::with([
            'cart.cartitems.serial.stock.product.brand',
            'cart.cartitems.serial.stock.product.category',
            'user',
            'customer'
        ])->get();
        return response()->json($bills);
    }
    public function delete($id)
    {
        // $bill=Bill::findOrFail($id);
        $bill = Bill::with([
            'cart.cartitems.serial.stock.product',
        ])->where('id', $id)->first();
        
        foreach ($bill->cart as $cart) {
            foreach ($cart->cartitems as $cartItem) {
                $product = $cartItem->serial->stock;
                return response()->json($bill->cart->cartitems);
                // Subtract cart item quantity from product quantity
                $newProductQuantity = $product->quantity - $cartItem->quantity;

                // Ensure product quantity doesn't go below zero
                $product->quantity = max($newProductQuantity, 0);

                // Save the updated product quantity
                $product->save();
            }
        }
        $bill->delete();
        return response()->json(['message' => 'Bill deleted updated successfully!']);
    }
}
