<?php

namespace App\Http\Controllers\PaymentType;

use App\Http\Controllers\Controller;
use App\Models\Paymenttype;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $payment = Paymenttype::with('user')->get();
        return response()->json($payment);
    }
    public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|string|max:255',
            'user_id' => 'required',
        ]);
        $paymentType = new Paymenttype();
        $paymentType->pt_name = $request->payment_type;
        $paymentType->user_id = $request->user_id;
        $paymentType->save();
        return response()->json(['message' => 'Payment Type successfully Added']);
    }
    public function update(Request $request)
    {

        $request->validate([
            'edit_payment_type' => 'required|string|max:255',
            'edit_user_id' => 'required|exists:users,id',
            'edit_status' => 'required|integer|in:0,1',
        ]);
        $paymentType = Paymenttype::findOrFail($request->id);
        $paymentType->update([
            'pt_name' => $request->input('edit_payment_type'),
            'user_id' => $request->input('edit_user_id'),
            'status' => $request->input('edit_status'),
        ]);
        return response()->json(['message' => 'Payment Type Updated successfully Added']);
    }
    public function delete($id)
    {
        $payment = Paymenttype::find($id);
        $payment->delete();
        return response()->json(['message' => 'Brand delete successfully']);
    }
}
