<?php

namespace App\Http\Controllers\Serial;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Serial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Str;

class SerialController extends Controller
{
    public function index()
    {
        $serials = Serial::with('user')->get();

        return response()->json($serials);
    }
    public function store(Request $request)
    {
        $request->validate([
            'rows.*.serial_no' => 'required',
            'rows.*.barcode_no' => 'required',
            'rows.*.color' => 'required',
            'rows.*.image' => 'nullable|string',
            'rows.*.userid' => 'required',
            'rows.*.stocksId' => 'required'
        ]);
        foreach ($request->rows as $rowData) {
            $serial = new Serial();
            $serial->serial_no = $rowData['serial_no'];
            $serial->barcode_no = $rowData['barcode_no'];
            $serial->color = $rowData['color'];
            $serial->stock_id = $rowData['stocksId'];
            $serial->user_id = $rowData['userid'];
            if (!empty($rowData['image'])) {
                $position = strpos($rowData['image'], ';');
                $sub = substr($rowData['image'], 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = rand(1, 1000) . '_' . $rowData['serial_no'] . '.' . $ext;
                $image = str_replace('data:image/' . $ext . ';base64,', '', $rowData['image']);
                $image = str_replace(' ', '+', $image);
                $imagePath = public_path('backend/images/serial/' . $imageName);
                if (!File::isDirectory(public_path('backend/images/serial'))) {
                    File::makeDirectory(public_path('backend/images/serial'), 0755, true, true);
                }
                File::put($imagePath, base64_decode($image));
                $serial->image = $imageName;
            }
            $serial->save();
        }
        return response()->json($request->rows);
    }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'serial_no' => 'required',
    //         'barcode_no' => 'required',
    //         'color' => 'required',
    //         'status' => 'required',
    //         'return_status' => 'required',
    //         'image' => 'nullable|string',
    //         'user_id' => 'required'
    //     ]);



    //     $serial = Serial::findOrFail($request->id);
    //     $product = $serial->stock->product;

    //     if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
    //         // Delete old image if it exists
    //         $oldImagePath = public_path('backend/images/serial/' . $serial->image);
    //         if ($serial->image && file_exists($oldImagePath)) {
    //             unlink($oldImagePath);
    //         }

    //         // Process the new image
    //         $position = strpos($request->image, ';');
    //         $sub = substr($request->image, 0, $position);
    //         $ext = explode('/', $sub)[1];
    //         $imageName = rand(1, 1000) . '_' . $request->serial_no . '.' . $ext;
    //         $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
    //         $image = str_replace(' ', '+', $image);

    //         // Ensure the directory exists and save the new image
    //         $imagePath = public_path('backend/images/serial/' . $imageName);
    //         if (!File::isDirectory(public_path('backend/images/serial'))) {
    //             File::makeDirectory(public_path('backend/images/serial'), 0755, true, true);
    //         }

    //         File::put($imagePath, base64_decode($image));
    //         $serial->image = $imageName;
    //     }

    //     $serial->serial_no = $request->serial_no;
    //     $serial->barcode_no = $request->barcode_no;
    //     $serial->color = $request->color;
    //     $serial->user_id = $request->user_id;
    //     $serial->status = $request->status;
    //     $serial->return_status = $request->return_status;
    //     $product->decrement('quantity');
    //     $serial->save();
    //     return response()->json(['message' => 'Serial details updated successfully']);
    // }

    public function update(Request $request)
    {
        $request->validate([
            'serial_no' => 'required',
            'barcode_no' => 'required',
            'color' => 'required',
            'status' => 'required',
            'return_status' => 'required',
            'image' => 'nullable|string',
            'user_id' => 'required'
        ]);

        $serial = Serial::findOrFail($request->id);
        $product = $serial->stock->product;

        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $oldImagePath = public_path('backend/images/serial/' . $serial->image);
            if ($serial->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }


            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->serial_no . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/serial/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/serial'))) {
                File::makeDirectory(public_path('backend/images/serial'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $serial->image = $imageName;
        }

        $serial->serial_no = $request->serial_no;
        $serial->barcode_no = $request->barcode_no;
        $serial->color = $request->color;
        $serial->user_id = $request->user_id;
        $serial->status = $request->status;

        if ($serial->return_status != $request->return_status) {
            if ($request->return_status == 1) {
                $product->decrement('quantity', 1);
            }
            if ($request->return_status == 0) {
                $product->increment('quantity', 1);
            }
        }
        $serial->return_status = $request->return_status;
        $serial->save();

        return response()->json(['message' => 'Serial details updated successfully']);
    }

    // public function delete($id)
    // {
    //     $serial = Serial::find($id);
    //     $image = $serial->image;
    //     $imagePath = public_path('backend/images/serial/' . $image);
    //     if ($image && file_exists($imagePath)) {
    //         unlink($imagePath);
    //         $serial->delete();
    //     } else {
    //         $serial->delete();
    //     }
    // }

    public function delete($id)
    {
        $serial = Serial::findOrFail($id);
        $stock = $serial->stock;
        $product = $stock->product;
        $image = $serial->image;
        $imagePath = public_path('backend/images/serial/' . $image);

        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
        }
        $stock->decrement('stock_quantity', 1);
        $product->decrement('quantity', 1);
        $serial->delete();

        return response()->json(['message' => 'Serial and associated data deleted successfully']);
    }

    public function getSerialsByStock($stockId)
    {
        $serials = Serial::where('stock_id', $stockId)->get(['serial_no']);
        $generator = new BarcodeGeneratorPNG();
        $serialsWithBarcodes = [];
        foreach ($serials as $serial) {
            $serialsWithBarcodes[] = [
                'serial_no' => $serial->serial_no,
                'barcode' => base64_encode($generator->getBarcode($serial->serial_no, $generator::TYPE_CODE_128))
            ];
        }
        return response()->json($serialsWithBarcodes);
    }

    //final
    // public function searchBarcode(Request $request)
    // {
    //     $barcode = $request->input('barcode');
    //     $cartId = $request->input('cart_id');
    //     $newQuantity = $request->input('quantity', 1); // Allow quantity to be specified in the request

    //     // Find the serial based on the barcode
    //     $serial = Serial::with(['stock.product', 'user'])
    //         ->where('barcode_no', $barcode)
    //         ->first();

    //     if (!$serial) {
    //         return response()->json(['message' => 'Serial not found'], 404);
    //     }

    //     // Check if a cart exists for the cart_id provided
    //     $cart = $cartId ? Cart::find($cartId) : null;

    //     // If no valid cart_id is provided or cart does not exist, create a new cart
    //     if (!$cart) {
    //         $cart = new Cart();
    //         $cart->cart_id = 'LP' . substr((string) Str::uuid(), 0, 4); // Unique cart ID
    //         $cart->save(); // Save the new cart
    //     }

    //     // Create a new CartItem with the same serial_id, allowing duplicates
    //     CartItem::create([
    //         'cart_id' => $cart->id,
    //         'serial_id' => $serial->id,
    //         'quantity' => $newQuantity,  // Default or specified quantity
    //         'item_no' => $serial->stock->product->id,
    //         'unit_price' => $serial->stock->selling_price // Use the selling price
    //     ]);

    //     return response()->json([
    //         'cart_id' => $cart->id,
    //         'serial' => $serial
    //     ]);
    // }


    //final but testing cartItmes
    // public function searchBarcode(Request $request)
    // {
    //     $barcode = $request->input('barcode');
    //     $cartId = $request->input('cart_id');
    //     $newQuantity = $request->input('quantity', 1); // Allow quantity to be specified in the request

    //     // Find the serial based on the barcode
    //     $serial = Serial::with(['stock.product', 'user'])
    //         ->where('barcode_no', $barcode)
    //         ->first();

    //     if (!$serial) {
    //         return response()->json(['message' => 'Serial not found'], 404);
    //     }

    //     // Check if the product's quantity is 0
    //     if ($serial->stock->product->quantity == 0) {
    //         return response()->json(['message' => 'Product is out of stock'], 400);
    //     }

    //     // Check if a cart exists for the cart_id provided
    //     $cart = $cartId ? Cart::find($cartId) : null;

    //     // If no valid cart_id is provided or cart does not exist, create a new cart
    //     if (!$cart) {
    //         $cart = new Cart();
    //         $cart->cart_id = 'LP' . substr((string) Str::uuid(), 0, 4); // Unique cart ID
    //         $cart->save(); // Save the new cart
    //     }

    //     // Create a new CartItem with the same serial_id, allowing duplicates
    //     CartItem::create([
    //         'cart_id' => $cart->id,
    //         'serial_id' => $serial->id,
    //         'quantity' => $newQuantity,  // Default or specified quantity
    //         'item_no' => $serial->stock->product->id,
    //         'unit_price' => $serial->stock->selling_price // Use the selling price
    //     ]);

    //     return response()->json([
    //         'cart_id' => $cart->id,
    //         'serial' => $serial
    //     ]);
    // }


    public function searchBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $cartId = $request->input('cart_id');
        $newQuantity = $request->input('quantity', 1); // Allow quantity to be specified in the request

        // Check if a cart exists for the cart_id provided
        $cart = $cartId ? Cart::find($cartId) : null;

        // If no valid cart_id is provided or cart does not exist, create a new cart
        if (!$cart) {
            $cart = new Cart();
            $cart->cart_id = 'LP' . substr((string) Str::uuid(), 0, 4); // Unique cart ID
            $cart->save(); // Save the new cart
        }

        // Find the serial based on the barcode, but exclude items already in the cart
        $serial = Serial::with(['stock.product', 'user'])
            ->where('barcode_no', $barcode)
            ->whereDoesntHave('stock.product.cartItems', function ($query) use ($cart) {
                $query->where('cart_id', $cart->id);
            })
            ->first();

        if (!$serial) {
            return response()->json(['message' => 'Serial not found or already in the cart'], 404);
        }

        // Check if the product's quantity is 0
        if ($serial->stock->product->quantity == 0) {
            return response()->json(['message' => 'Product is out of stock'], 400);
        }

        // Check if the item already exists in the cart
        $existingCartItem = CartItem::where('cart_id', $cart->id)
            ->where('item_no', $serial->stock->product->id)
            ->first();

        if ($existingCartItem) {
            // If the item already exists, increment the quantity
            $existingCartItem->quantity += $newQuantity;
            $existingCartItem->save();

            return response()->json([
                'message' => 'Item already exists in the cart, quantity incremented.',
                'cart_id' => $cart->id,
                'quantity' => $existingCartItem->quantity,
                'serial' => $serial
            ]);
        }

        // If the item doesn't exist, create a new CartItem
        CartItem::create([
            'cart_id' => $cart->id,
            'serial_id' => $serial->id,
            'quantity' => $newQuantity,  // Default or specified quantity
            'item_no' => $serial->stock->product->id,
            'unit_price' => $serial->stock->selling_price // Use the selling price
        ]);

        return response()->json([
            'message' => 'Item added to cart.',
            'cart_id' => $cart->id,
            'serial' => $serial
        ]);
    }
    // public function delete_saledata($item_no)
    // {
    //     $cartItem = CartItem::where('item_no', $item_no)
    //         ->whereNull('sold_price')
    //         ->whereNull('profit')
    //         ->whereNull('total_profit')
    //         ->get();

    //     if ($cartItem) {
    //         $cartItem->delete();
    //         $entriesToDelete = CartItem::whereNull('sold_price')
    //         ->whereNull('profit')
    //         ->whereNull('total_profit')
    //         ->delete();
    //         return response()->json([
    //             'message' => 'Item deleted successfully',
    //             'item' => $cartItem
    //         ]);
    //     } else {
    //         return response()->json([
    //             'message' => 'Item not found'
    //         ], 404);
    //     }
    // }

    public function delete_saledata($item_no)
    {
        // Retrieve the cart items matching the conditions
        $cartItems = CartItem::where('item_no', $item_no)
            ->whereNull('sold_price')
            ->whereNull('profit')
            ->whereNull('total_profit')
            ->get();

        // Check if there are any items to delete
        if ($cartItems->isNotEmpty()) {
            // Loop through and delete each cart item
            foreach ($cartItems as $cartItem) {
                $cartItem->delete();
            }

            return response()->json([
                'message' => 'Item(s) deleted successfully',
                'item' => $cartItems
            ]);
        } else {
            // Return error message if no items are found
            return response()->json([
                'message' => 'Item not found'
            ], 404);
        }
    }
}
