<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::with(['user'])->get();
        return response()->json($supplier);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'shopname' => 'required|string|max:255',
            'image' => 'nullable|string',
            // 'product_id' => 'required',
            'user_id' => 'required'
        ]);
        $supplier = new Supplier();

        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->shopname = $request->shopname;
        // $supplier->product_id = $request->product_id;
        $supplier->user_id = $request->user_id;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/supplier/' . $imageName);

            // Ensure the directory exists
            if (!File::isDirectory(public_path('backend/images/supplier'))) {
                File::makeDirectory(public_path('backend/images/supplier'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $supplier->image = $imageName;
        }

        $supplier->save();

        return response()->json(['message' => 'Supplier created successfully']);
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $image = $supplier->image;
        $imagePath = public_path('backend/images/supplier/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $supplier->delete();
        } else {
            $supplier->delete();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|exists:suppliers,id',
            'edit_name' => 'required|string|max:255',
            'edit_email' => 'required|email',
            'edit_address' => 'required|string|max:255',
            'edit_phone' => 'required|string|max:15',
            'edit_shopname' => 'required|string|max:255',
            'edit_image' => 'nullable|string',
            'edit_user_id' => 'required',
            'edit_product_id' => 'required'
        ]);
        $supplier = Supplier::find($request->edit_id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
        $supplier->update([
            'name' => $request->edit_name,
            'email' => $request->edit_email,
            'address' => $request->edit_address,
            'phone' => $request->edit_phone,
            'shopname' => $request->edit_shopname,
            'user_id' => $request->edit_user_id,
            'product_id' => $request->edit_product_id,
        ]);

        if ($request->has('edit_image') && strpos($request->edit_image, 'data:image/') === 0) {
            $oldImagePath = public_path('backend/images/supplier/' . $supplier->image);
            if ($supplier->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Process the new image
            $position = strpos($request->edit_image, ';');
            $sub = substr($request->edit_image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->edit_name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->edit_image);
            $image = str_replace(' ', '+', $image);

            // Ensure the directory exists and save the new image
            $imagePath = public_path('backend/images/supplier/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/supplier'))) {
                File::makeDirectory(public_path('backend/images/supplier'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $supplier->image = $imageName;
        }

        $supplier->save();

        return response()->json(['message' => 'Supplier updated successfully']);
    }
}
