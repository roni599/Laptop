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
        // $barcodes = [];

        // $generator = new BarcodeGeneratorPNG();
        // foreach ($serials as $serial) {
        //     $barcodes[] = [
        //         'user' => $serial->user,
        //         'serial' => $serial,
        //         'barcode' => base64_encode($generator->getBarcode($serial->serial_no, $generator::TYPE_CODE_128))
        //     ];
        // }

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
    public function update(Request $request)
    {
        $request->validate([
            'serial_no' => 'required',
            'barcode_no' => 'required',
            'color' => 'required',
            'status' => 'required',
            'return_status' => 'required',
            'image' => 'nullable|string',
        ]);

        $serial = Serial::findOrFail($request->id);

        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            // Delete old image if it exists
            $oldImagePath = public_path('backend/images/serial/' . $serial->image);
            if ($serial->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Process the new image
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->serial_no . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            // Ensure the directory exists and save the new image
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
        $serial->status = $request->status;
        $serial->return_status = $request->return_status;

        $serial->save();
        return response()->json(['message' => 'Serial details updated successfully']);
    }
    public function delete($id)
    {
        $serial = Serial::find($id);
        $image = $serial->image;
        $imagePath = public_path('backend/images/serial/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $serial->delete();
        } else {
            $serial->delete();
        }
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
    
    public function searchBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $cartId = $request->input('cart_id');
        
        // Retrieve serial data based on barcode
        $serial = Serial::with(['stock.product', 'user'])
            ->where('barcode_no', $barcode)
            ->first();

        // Check if cart_id is provided
        if ($cartId) {
            // Check if the cart_id exists in the Cart table
            $cart = Cart::find($cartId);

            if ($cart) {
                // Cart ID exists, return the existing ID
                $cartItem = new CartItem();
                $cartItem->cart_id = $cart->id;
                $cartItem->serial_id = $serial->id;
                $cartItem->quantity = 1;
                $cartItem->item_no = $serial->stock->product->id;
                $cartItem->price = $serial->stock->product->selling_price;
                $cartItem->save();
                return response()->json([
                    $cart->id,
                    $serial
                ]);
            } else {
                // Cart ID does not exist, create a new cart
                $cart = new Cart();
                $cart->cart_id = $cart; // Optionally set cart_id if needed
                $cart->save();

                $cartItem = new CartItem();
                $cartItem->cart_id = $cart->id;
                $cartItem->serial_id = $serial->id;
                $cartItem->quantity = 1;
                $cartItem->item_no = $serial->stock->product->id;
                $cartItem->price = $serial->stock->product->selling_price;
                $cartItem->save();
                return response()->json([
                    $cart->id,
                    $serial
                ]);
            }
        } else {
            // No cart_id provided, create a new cart
            $cart = new Cart();
            $cart->cart_id = 'LP' . substr((string) Str::uuid(), 0, 4);
            $cart->save();

            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->serial_id = $serial->id;
            $cartItem->quantity = 1;
            $cartItem->item_no = $serial->stock->product->id;
            $cartItem->price = $serial->stock->selling_price;
            $cartItem->save();
            return response()->json([
                $cart->id,
                $serial
            ]);
        }
    }
    public function delete_saledata($id){
        return response()->json($id);
    }
}
