<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::all();
        return response()->json($brand);
    }
    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);
        $brand = new Brand();
        $brand->brand_name = $request->brand_name;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->brand_name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/brands/' . $imageName);

            // Ensure the directory exists
            if (!File::isDirectory(public_path('backend/images/brands'))) {
                File::makeDirectory(public_path('backend/images/brands'), 0755, true, true);
            }
            File::put($imagePath, base64_decode($image));
            $brand->brand_image = $imageName;
        }
        $brand->save();
        return response()->json('created');
    }
    public function brandUpdate(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'status' => 'required'
        ]);

        $brand = Brand::findOrFail($request->id);
        $brand->update($request->only('brand_name', 'status'));
        if (!$brand) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/brands/' . $brand->image);
            if ($brand->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);
            $imagePath = public_path('backend/images/brands/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/brands'))) {
                File::makeDirectory(public_path('backend/images/brands'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $brand->brand_image = $imageName;
        }
        $brand->update([
            'brand_name' => $request->brand_name,
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'Brand updated successfully']);
    }
    public function delete($id)
    {
        $brand = Brand::find($id);
        $image = $brand->brand_image;
        $imagePath = public_path('backend/images/brands/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $brand->delete();
        } else {
            $brand->delete();
        }
        return response()->json(['message' => 'Brand delete successfully']);
    }
}
