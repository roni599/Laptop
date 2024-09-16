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
        // return response()->json($request->all());
        $validatedData = $request->validate([
            'customerName' => 'required',
            'customerPhone' => 'required',
            'customerAddress' => 'nullable',
            'customerEmail' => 'nullable|email',
            'customerBirthday' => 'nullable',
            'customerNid' => 'nullable',
            'user_id' => 'required',
            'items' => 'required',
            'validInputs' => 'required',
            'cartId' => 'required|exists:carts,id',
            'totalsaleprice' => 'required',
            'validInputs2' => 'required',
        ]);




        $customer = Customer::create([
            'customer_name' => $validatedData['customerName'],
            'phone' => $validatedData['customerPhone'],
            'address' => $validatedData['customerAddress'],
            'email' => $validatedData['customerEmail'],
            'dob' => $validatedData['customerBirthday'],
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

        // foreach ($validatedData['items'] as $item) {
        //     // Find the product and update its quantity
        //     $product = Product::find($item['stock']['product_id']);
        //     if ($product) {
        //         $product->quantity -= $item['quantity'];
        //         $product->save();
        //     }
        //     $cartItem = CartItem::where('item_no', $item['stock']['product_id'])->first();
        //     if ($cartItem) {
        //        $cartItem->quantity=$item['quantity'];
        //        $cartItem->price=$item['quantity']* $item['stock']['selling_price'];
        //        $cartItem->save();
        //     }
        // }

        foreach ($validatedData['items'] as $item) {
            $product = Product::find($item['stock']['product_id']);
            if ($product) {
                $product->decrement('quantity', $item['quantity']);
            }
            $cartItem = CartItem::where('item_no', $item['stock']['product_id'])->first();
            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $item['quantity'],
                    'price' => $item['quantity'] * $item['stock']['selling_price'],
                ]);
            }
        }

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
                ]);
            }
        }


        // $pay = [];
        // $pay = Paymenttype::whereIn('id', $validatedData['validInputs'])->get()->keyBy('id'); // Fetch and key by 'id'

        // foreach ($validatedData['items'] as $item) {
        //     $product = Product::find($item['stock']['product_id']);
        //     if ($product) {
        //         $product->quantity -= $item['quantity'];
        //         $product->save();
        //     }
        //     foreach ($validatedData['validInputs'] as $paymenttype) {
        //         if (isset($pay[$paymenttype])) {
        //             Bill::create([
        //                 'total_price' => $item['totalPrice'],
        //                 'quantity' => $item['quantity'],
        //                 'price' => $item['stock']['selling_price'],
        //                 'customer_id' => $customer->id,
        //                 'user_id' => $validatedData['user_id'],
        //                 'serial_id' => $item['id'],
        //                 'paymenttype_id' => $pay[$paymenttype]->id,
        //             ]);
        //         }
        //     }
        // }

        return response()->json($bill->id);
    }

    // public function billGenerate($id){
    //     // $bill = Bill::with(['cart.cartItems', 'customer'])->find($id);
    //     $bill = Bill::with(['cart.cartItems.serial.stock.product', 'customer'])->find($id);
    //     $payment=Reserve::with(['paymenttype'])->find($id);
    //     return response()->json($bill);
    // }

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
}
