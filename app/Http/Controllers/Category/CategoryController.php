<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $category = new Category();
        $category->cat_name = $request->cat_name;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->cat_name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/categories/' . $imageName);

            // Ensure the directory exists
            if (!File::isDirectory(public_path('backend/images/categories'))) {
                File::makeDirectory(public_path('backend/images/categories'), 0755, true, true);
            }
            File::put($imagePath, base64_decode($image));
            $category->cat_img = $imageName;
        }
        $category->save();
        return response()->json(['message' => 'Category Created successfully']);
    }

    public function CategoryUpdate(Request $request)
    {

        $request->validate([
            'cat_name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'status' => 'required'
        ]);
        $category = Category::findOrFail($request->id);

        $category->update($request->only('cat_name', 'status'));
        if (!$category) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/categories/' . $category->image);
            if ($category->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->cat_name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);
            $imagePath = public_path('backend/images/categories/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/categories'))) {
                File::makeDirectory(public_path('backend/images/categories'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $category->cat_img = $imageName;
        }
        $category->update([
            'brand_name' => $request->cat_name,
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'Category updated successfully']);
    }
    public function delete($id)
    {
        $category = Category::find($id);
        $image = $category->cat_img;
        $imagePath = public_path('backend/images/categories/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $category->delete();
        } else {
            $category->delete();
        }
        return response()->json(['message' => 'Category delete successfully']);
    }
}
