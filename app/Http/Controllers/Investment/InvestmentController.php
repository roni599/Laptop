<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Reserve;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with(['user', 'paymenttype'])->get();
        return response()->json($investments);
    }
    public function store(Request $request)
    {

        $request->validate([
            'investment_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'user_id' => 'required',
            'paymenttype' => 'required',
            'invest_date' => 'required|date',
        ]);

        $investment = new Investment();
        $investment->In_name = $request->investment_name;
        $investment->Amount = $request->amount;
        $investment->date = $request->invest_date;
        $investment->user_id = $request->user_id;
        $investment->paymenttype_id = $request->paymenttype;

        $investment->save();

        $investment_id = $investment->id;
        $reserve = new Reserve();
        $reserve->transaction_type = 'in';
        $reserve->amount = $request->amount;
        $reserve->investment_id = $investment_id;
        $reserve->user_id = $request->user_id;
        $reserve->payment_type_id = $request->paymenttype;
        $reserve->save();
        return response()->json(['message' => 'Investment successfully Created']);
    }
    public function update(Request $request)
    {
        $request->validate([
            'edit_investment_name' => 'required|string|max:255',
            'edit_amount' => 'required|numeric|min:0',
            'edit_user_id' => 'required',
            'edit_paymenttype' => 'required',
            'edit_invest_date' => 'required|date',
            'edit_status' => 'required|integer|in:0,1',
        ]);
        $investment = Investment::findOrFail($request->id);
        $investment->update([
            'In_name' => $request->input('edit_investment_name'),
            'Amount' => $request->input('edit_amount'),
            'user_id' => $request->input('edit_user_id'),
            'paymenttype_id' => $request->input('edit_paymenttype'),
            'date' => $request->input('edit_invest_date'),
            'status' => $request->input('edit_status'),
        ]);

        $reserve = Reserve::where('investment_id', $request->input('id'))->first();
        $reserve->update([
            'amount' => $request->input('edit_amount'),
            'status' => $request->input('edit_status'),
            'payment_type_id' => $request->input('edit_paymenttype'),
        ]);

        return response()->json(['message' => 'Investment Updated successfully']);
    }
    public function delete($id)
    {
        $investment = Investment::findOrFail($id);
        $investment->delete();
        return response()->json(['message' => 'Investment delete successfully']);
    }
}
