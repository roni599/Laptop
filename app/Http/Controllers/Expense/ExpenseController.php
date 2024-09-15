<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::with(['user', 'expenser', 'expensecategory', 'paymenttype'])->get();
        return response()->json($expense);
    }
    public function store(Request $request)
    {
        $request->validate([
            'expenserName' => 'required',
            'expense_description' => 'required',
            'amount' => 'required|numeric',
            'paymenttype' => 'required',
            'date' => 'required',
            'expensecategory' => 'required',
            'cost_type' => 'required',
            'user_id' => 'required',
            'image' => 'required',
        ]);

        $expense = new Expense();

        $expense->expenser_id = $request->expenserName;
        $expense->expense_desc = $request->expense_description;
        $expense->amount = $request->amount;
        $expense->cost_type = $request->cost_type;
        $expense->payment_type_id = $request->paymenttype;
        $expense->user_id = $request->user_id;
        $expense->date = $request->date;
        $expense->expense_category_id = $request->expensecategory;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->cost_type . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/expense/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/expense'))) {
                File::makeDirectory(public_path('backend/images/expense'), 0755, true, true);
            }
            File::put($imagePath, base64_decode($image));
            $expense->receipt_img = $imageName;
        }

        $expense->save();

        $expense_id = $expense->id;
        $reserve = new Reserve();
        $reserve->transaction_type = 'out';
        $reserve->amount = $request->amount;
        $reserve->expense_id = $expense_id;
        $reserve->user_id = $request->user_id;
        $reserve->payment_type_id = $request->paymenttype;
        $reserve->save();
        return response()->json("expense created successfully");
    }
    public function update(Request $request)
    {
        $request->validate([
            'expenserName' => 'required',
            'expense_description' => 'required',
            'amount' => 'required|numeric',
            'paymenttype' => 'required',
            'date' => 'required',
            'expensecategory' => 'required',
            'cost_type' => 'required',
            'user_id' => 'required',
            'image' => 'required',
            'status' => 'required'
        ]);

        $expens = Expense::findOrFail($request->id);

        $expens->expenser_id = $request->expenserName;
        $expens->expense_desc = $request->expense_description;
        $expens->amount = $request->amount;
        $expens->payment_type_id = $request->paymenttype;
        $expens->date = $request->date;
        $expens->expense_category_id = $request->expensecategory;
        $expens->cost_type = $request->cost_type;
        $expens->user_id = $request->user_id;
        $expens->status = $request->status;

        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/expense/' . $expens->image);
            if ($expens->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->expenserName . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);
            $imagePath = public_path('backend/images/expense/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/expense'))) {
                File::makeDirectory(public_path('backend/images/expense'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $expens->receipt_img = $imageName;
        }
        $expens->save();

        $reserve = Reserve::where('expense_id', $request->input('id'))->first();
        $reserve->update([
            'amount' => $request->input('amount'),
            'status' => $request->input('status'),
            'payment_type_id' => $request->input('paymenttype'),
        ]);
        return response()->json('expenst and reserve successfully');
    }
    public function delete($id){
        $investment = Expense::findOrFail($id);
        $investment->delete();
        return response()->json(['message' => 'Expense delete successfully']);
    }
}
