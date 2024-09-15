<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::where('id',19)->first();
        return response()->json($customer);
    }

    public function store(Request $request){
        return response()->json($request->all());
    }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:customers,email',
    //         'address' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //         'nid' => 'required|string|max:20',
    //         'image' => 'nullable|string',
    //     ]);

    //     $customer = new Customer();

    //     $customer->name = $request->name;
    //     $customer->email = $request->email;
    //     $customer->address = $request->address;
    //     $customer->phone = $request->phone;
    //     $customer->nid = $request->nid;

    //     $imageName = '';
    //     if ($request->image) {
    //         $position = strpos($request->image, ';');
    //         $sub = substr($request->image, 0, $position);
    //         $ext = explode('/', $sub)[1];
    //         $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
    //         $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
    //         $image = str_replace(' ', '+', $image);

    //         $imagePath = public_path('backend/images/customer/' . $imageName);

    //         // Ensure the directory exists
    //         if (!File::isDirectory(public_path('backend/images/customer'))) {
    //             File::makeDirectory(public_path('backend/images/customer'), 0755, true, true);
    //         }

    //         File::put($imagePath, base64_decode($image));
    //         $customer->image = $imageName;
    //     }

    //     $customer->save();

    //     return response()->json(['message' => 'Customer created successfully']);
    // }

    // public function delete($id)
    // {
    //     $customer = Customer::find($id);
    //     $image = $customer->image;
    //     $imagePath = public_path('backend/images/customer/' . $image);
    //     if ($image && file_exists($imagePath)) {
    //         unlink($imagePath);
    //         $customer->delete();
    //     } else {
    //         $customer->delete();
    //     }
    // }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:customers,id',
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:customers,email,' . $request->id,
    //         'address' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //         'nid' => 'required|string|max:20',
    //         'image' => 'nullable|string',
    //     ]);

    //     $customer = Customer::find($request->id);
    //     if (!$customer) {
    //         return response()->json(['message' => 'Employee not found'], 404);
    //     }

    //     $customer->update($request->only('name', 'email', 'address', 'phone', 'nid'));

    //     if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
    //         $imagePath = public_path('backend/images/customer/' . $customer->image);
    //         if ($customer->image && file_exists($imagePath)) {
    //             unlink($imagePath);
    //         }

    //         $position = strpos($request->image, ';');
    //         $sub = substr($request->image, 0, $position);
    //         $ext = explode('/', $sub)[1];
    //         $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
    //         $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
    //         $image = str_replace(' ', '+', $image);

    //         $imagePath = public_path('backend/images/customer/' . $imageName);
    //         if (!File::isDirectory(public_path('backend/images/customer'))) {
    //             File::makeDirectory(public_path('backend/images/customer'), 0755, true, true);
    //         }

    //         File::put($imagePath, base64_decode($image));
    //         $customer->image = $imageName;
    //     }

    //     $customer->save();

    //     return response()->json(['message' => 'Customer updated successfully']);
    // }

    // public function subproduct($id){
    //     $category=Product::where('category_id',$id)->get();
    //     return response()->json($category);
    // }
}
