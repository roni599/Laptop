<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expense = ExpenseCategory::with(['user'])->get();
        return response()->json($expense);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ecname' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|string',
        ]);

        $expenseCategory = new ExpenseCategory();
        $expenseCategory->category_name = $request->ecname;
        $expenseCategory->user_id = $request->user_id;


        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->ecname . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/expensecategory/' . $imageName);

            // Ensure the directory exists
            if (!File::isDirectory(public_path('backend/images/expensecategory'))) {
                File::makeDirectory(public_path('backend/images/expensecategory'), 0755, true, true);
            }
            File::put($imagePath, base64_decode($image));
            $expenseCategory->images = $imageName;
        } else {
            $expenseCategory->images = null;
        }
        $expenseCategory->save();

        return response()->json(['message' => 'expense category created successfully']);
    }
    public function update(Request $request)
    {
        $request->validate([
            'ecname' => 'required|string|max:255',
            'user_id' => 'required',
            'status' => 'required|in:0,1',
            'image' => 'nullable',
        ]);
        $expenseCategory = ExpenseCategory::findOrFail($request->id);
        $expenseCategory->category_name = $request['ecname'];
        $expenseCategory->user_id = $request['user_id'];
        $expenseCategory->status = $request['status'];

        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/expensecategory/' . $expenseCategory->image);
            if ($expenseCategory->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);
            $imagePath = public_path('backend/images/expensecategory/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/expensecategory'))) {
                File::makeDirectory(public_path('backend/images/expensecategory'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $expenseCategory->images = $imageName;
        }
        $expenseCategory->save();
        return response()->json(['message' => 'Expense Category updated successfully']);
    }
    public function delete($id)
    {
        $expenseCategory = ExpenseCategory::find($id);
        $image = $expenseCategory->images;
        $imagePath = public_path('backend/images/expensecategory/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $expenseCategory->delete();
        } else {
            $expenseCategory->delete();
        }
        return response()->json(['message' => 'Expensecategory delete successfully']);
    }
}
