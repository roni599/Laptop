<?php

namespace App\Http\Controllers\Calculate;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Investment;
use App\Models\Product;
use App\Models\Reserve;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class CalculateController extends Controller
{
    public function product(Request $request)
    {
        $categories = Product::select('cat_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->groupBy('cat_id')
            ->with('category:id,cat_name')
            ->get();
        $products = Product::select('cat_id', 'brand_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->groupBy('cat_id', 'brand_id')
            ->with([
                'category:id,cat_name',
                'brand:id,brand_name'
            ])
            ->get();


        $todaysBills = Bill::whereDate('created_at', Carbon::today())->count();
        $todaysProfit = Bill::whereDate('created_at', Carbon::today())
            ->with('cart.cartItems')
            ->get()
            ->sum(function ($bill) {
                return $bill->cart->cartItems->sum('total_profit');
            });


        $currentMonthCost = Expense::whereMonth('expenses.created_at', Carbon::now()->month)
            ->whereYear('expenses.created_at', Carbon::now()->year)
            ->join('expensecategories', 'expenses.expense_category_id', '=', 'expensecategories.id')
            ->where('expensecategories.cost_type', 1)
            ->sum('expenses.amount');
        // $currentMonthCost = Expense::whereMonth('created_at', Carbon::now()->month)
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->sum('amount');
        // $currentMonthCost = Reserve::whereMonth('created_at', Carbon::now()->month)
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->where('transaction_type', 'out')
        //     ->sum('amount');
        $thisMonthProfit = Bill::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->with('cart.cartItems')
            ->get()
            ->sum(function ($bill) {
                return $bill->cart->cartItems->sum('total_profit');
            });
        $thisMonthCostProfit = $thisMonthProfit - $currentMonthCost;

        // return response()->json([
        //     'status' => 'success',
        //     'categories' => $categories,
        //     'products' => $products,
        //     'todaysBills' => $todaysBills,
        //     'todaysBills' => $todaysBills,
        //     'todaysProfit' => $todaysProfit,
        //     'currentMonthCost' => $currentMonthCost,
        // ]);


        // Fetch today's expenses and group by payment type
        // $expenses = Reserve::with(['expense', 'paymentType'])
        // ->whereDate('created_at', $today)
        // ->where('transaction_type', 'in') // Filter for out transactions
        // ->get()
        // ->groupBy(function ($reserve) {
        //     return $reserve->paymentType->name ?? 'Others'; // Adjust 'name' to your payment type column
        // });
        // $today = Carbon::today();
        // $inexpenses = Reserve::with(['expense', 'paymentType'])
        //     ->whereDate('created_at', $today)
        //     ->where('transaction_type', 'in')
        //     ->get();

        // $insums = [];
        // $intotalSum = 0;
        // foreach ($inexpenses as $reserve) {
        //     $paymentTypeName = $reserve->paymentType->pt_name ?? 'Others'; // Get the payment type name
        //     if (!isset($sums[$paymentTypeName])) {
        //         $insums[$paymentTypeName] = 0; // Initialize sum for this payment type if not set
        //     }
        //     $insums[$paymentTypeName] += $reserve->amount; // Add the amount to the respective payment type sum
        //     $intotalSum += $reserve->amount; // Add to the total sum
        // }



        // $outexpenses = Reserve::with(['expense', 'paymentType'])
        //     ->whereDate('created_at', $today)
        //     ->where('transaction_type', 'out')
        //     ->get();

        // $outsums = [];
        // $outtotalSum = 0;
        // foreach ($outexpenses as $reserve) {
        //     $paymentTypeName = $reserve->paymentType->pt_name ?? 'Others'; // Get the payment type name
        //     if (!isset($sums[$paymentTypeName])) {
        //         $outsums[$paymentTypeName] = 0; // Initialize sum for this payment type if not set
        //     }
        //     $outsums[$paymentTypeName] += $reserve->amount; // Add the amount to the respective payment type sum
        //     $outtotalSum += $reserve->amount; // Add to the total sum
        // }

        // $sums = [];
        // foreach ($expenses as $reserve) {
        //     $paymentTypeName = $reserve->paymentType->pt_name ?? 'Others';
        //     if (!isset($sums[$paymentTypeName])) {
        //         $sums[$paymentTypeName] = 0;
        //     }
        //     $sums[$paymentTypeName] += $reserve->amount;
        // }
        // Calculate total amount for each payment type
        // $totals = $expenses->map(function ($group) {
        //     return [
        //         'total_amount' => $group->sum('amount'),
        //         'expenses' => $group->map(function ($reserve) {
        //             return [
        //                 'expense_name' => $reserve->expense->name ?? 'N/A', // Adjust 'name' to your expense name column
        //                 'amount' => $reserve->amount,
        //             ];
        //         }),
        //     ];
        // });
        // $netTotal=$intotalSum-$outtotalSum;

        $today = Carbon::today();

        // Fetch "in" transactions
        $inexpenses = Reserve::with(['expense', 'paymentType'])
            ->whereDate('created_at', $today)
            ->where('transaction_type', 'in')
            ->get();

        $insums = [];
        $intotalSum = 0;
        foreach ($inexpenses as $reserve) {
            $paymentTypeName = $reserve->paymentType->pt_name ?? 'Others'; // Get the payment type name
            if (!isset($insums[$paymentTypeName])) {
                $insums[$paymentTypeName] = 0; // Initialize sum for this payment type if not set
            }
            $insums[$paymentTypeName] += $reserve->amount; // Add the amount to the respective payment type sum
            $intotalSum += $reserve->amount; // Add to the total sum
        }

        // Fetch "out" transactions
        $outexpenses = Reserve::with(['expense', 'paymentType'])
            ->whereDate('created_at', $today)
            ->where('transaction_type', 'out')
            ->get();

        $outsums = [];
        $outtotalSum = 0;
        foreach ($outexpenses as $reserve) {
            $paymentTypeName = $reserve->paymentType->pt_name ?? 'Others'; // Get the payment type name
            if (!isset($outsums[$paymentTypeName])) {
                $outsums[$paymentTypeName] = 0; // Initialize sum for this payment type if not set
            }
            $outsums[$paymentTypeName] += $reserve->amount; // Add the amount to the respective payment type sum
            $outtotalSum += $reserve->amount; // Add to the total sum
        }

        // Calculate the difference (in - out) for each payment type
        $differences = [];
        $allPaymentTypes = array_unique(array_merge(array_keys($insums), array_keys($outsums)));

        foreach ($allPaymentTypes as $paymentType) {
            $inSum = $insums[$paymentType] ?? 0; // Get "in" sum, default to 0 if not set
            $outSum = $outsums[$paymentType] ?? 0; // Get "out" sum, default to 0 if not set
            $differences[$paymentType] = $inSum - $outSum; // Calculate the difference
        }

        $currentYear = Carbon::now()->year;

        // Fetch records grouped by month using Eloquent
        // $monthlyData = Bill::selectRaw('MONTH(created_at) as month,count()')
        //     ->whereYear('created_at', $currentYear)
        //     ->groupBy('month')
        //     ->orderBy('month', 'asc')
        //     ->get();

        // $monthlyData = Bill::selectRaw('MONTH(created_at) as month, COUNT(*) as bill_count')
        // ->whereYear('created_at', $currentYear)
        // ->groupBy('month')
        // ->orderBy('month', 'asc')
        // ->get();


        $allMonths = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];
        // $monthlyProfitData = Bill::selectRaw('MONTH(bills.created_at) as month, SUM(cartitems.total_profit) as total_profit')
        // ->join('carts', 'bills.cart_id', '=', 'carts.id') // Adjust the foreign key if needed
        // ->join('cartitems', 'carts.id', '=', 'cartitems.cart_id') // Joining the cartitems table
        // ->whereYear('bills.created_at', $currentYear)
        // ->groupBy('month')
        // ->orderBy('month', 'asc')
        // ->get();

        //monthlyprofit
        // $monthlyProfitData = Bill::selectRaw('MONTHNAME(bills.created_at) as month_name, SUM(cartitems.total_profit) as total_profit')
        //     ->join('carts', 'bills.cart_id', '=', 'carts.id')
        //     ->join('cartitems', 'carts.id', '=', 'cartitems.cart_id')
        //     ->whereYear('bills.created_at', $currentYear)
        //     ->groupBy('month_name')
        //     ->orderByRaw('MONTH(bills.created_at)')
        //     ->get()
        //     ->pluck('total_profit', 'month_name')
        //     ->toArray();

        // // Merge the actual data with all months
        // $finalData = array_merge($allMonths, $monthlyProfitData);

        // // Convert to a response format
        // $responseprofitData = [];
        // foreach ($finalData as $month => $total_profit) {
        //     $responseprofitData[] = [
        //         'month_name' => $month,
        //         'total_profit' => $total_profit,
        //     ];
        // }


        // Fetch the actual data grouped by month and count the records
        $monthlyData = Bill::selectRaw('MONTHNAME(created_at) as month_name, COUNT(*) as bill_count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month_name')
            ->orderByRaw('MONTH(created_at)')
            ->get()
            ->pluck('bill_count', 'month_name')
            ->toArray();

        // Merge the actual data with the allMonths array, ensuring missing months are set to 0
        $finalData = array_merge($allMonths, $monthlyData);

        // Convert the data into a format suitable for JSON response
        $response = [];
        foreach ($finalData as $month => $count) {
            $response[] = [
                'month_name' => $month,
                'bill_count' => $count,
            ];
        }


        // $monthlyData = Bill::selectRaw('MONTHNAME(created_at) as month_name, COUNT(*) as bill_count')
        // ->whereYear('created_at', $currentYear)
        // ->groupBy('month_name')
        // ->orderByRaw('MONTH(created_at)') // Ensure proper month order (January to December)
        // ->get();

        //monthly runnig cost
        // $monthlyRunningCost = Expense::selectRaw('MONTH(expenses.created_at) as month, SUM(expenses.amount) as total_amount')
        //     ->join('expensecategories', 'expenses.expense_category_id', '=', 'expensecategories.id')
        //     ->whereYear('expenses.created_at', $currentYear)
        //     ->where('expensecategories.cost_type', 1) // Adjust for the cost type you want
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get();

        // // Fill the allMonths array with actual data
        // foreach ($monthlyRunningCost as $data) {
        //     // Get the month name from the month number
        //     $monthName = date('F', mktime(0, 0, 0, $data->month, 1)); // Get month name by month number
        //     $allMonths[$monthName] = $data->total_amount; // Assign total amount to the respective month name
        // }

        // // Convert to a response format
        // $responseMonthlyRunnigCost = [];
        // foreach ($allMonths as $month => $total_amount) {
        //     $responseMonthlyRunnigCost[] = [
        //         'month_name' => $month,
        //         'total_amount' => $total_amount,
        //     ];
        // }

        $monthlyProfitData = Bill::selectRaw('MONTH(bills.created_at) as month, SUM(cartitems.total_profit) as total_profit')
            ->join('carts', 'bills.cart_id', '=', 'carts.id')
            ->join('cartitems', 'carts.id', '=', 'cartitems.cart_id')
            ->whereYear('bills.created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total_profit', 'month')
            ->toArray();

        // Fetch monthly running costs
        $monthlyRunningCost = Expense::selectRaw('MONTH(expenses.created_at) as month, SUM(expenses.amount) as total_amount')
            ->join('expensecategories', 'expenses.expense_category_id', '=', 'expensecategories.id')
            ->whereYear('expenses.created_at', $currentYear)
            ->where('expensecategories.cost_type', 1) // Adjust for the cost type you want
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total_amount', 'month')
            ->toArray();

        // Prepare final response with profit, running cost, and calculated profit
        $responsedatatotal = [];
        foreach ($allMonths as $month => $value) {
            // Get month number (1 for January, 2 for February, etc.)
            $monthNumber = array_search($month, array_keys($allMonths)) + 1;

            // Get total profit and running cost for the month, defaulting to 0 if not set
            $totalProfit = $monthlyProfitData[$monthNumber] ?? 0;
            $totalCost = $monthlyRunningCost[$monthNumber] ?? 0;

            // Calculate profit (total profit - total running cost)
            $profit = $totalProfit - $totalCost;

            // Build the response for each month
            $responsedatatotal[] = [
                'month_name' => $month,
                'total_profit' => $totalProfit,
                'total_running_cost' => $totalCost,
                'net_profit' => $profit,
            ];
        }


        return response()->json([
            'status' => 'success',
            'categories' => $categories,
            'products' => $products,
            'todaysBills' => $todaysBills,
            'todaysBills' => $todaysBills,
            'todaysProfit' => $todaysProfit,
            'currentMonthCost' => $currentMonthCost,
            'thisMonthProfit' => $thisMonthProfit,
            'thisMonthCostProfit' => $thisMonthCostProfit,
            'monthlyData' => $response,
            'responsedatatotal' => $responsedatatotal,
            // 'responseprofitData' => $responseprofitData,
            // 'responseMonthlyRunnigCost' => $responseMonthlyRunnigCost,
            'insums' => $insums,
            'outsums' => $outsums,
            'differences' => $differences,
            'totalin' => $intotalSum,
            'totalout' => $outtotalSum,
            'totaldifference' => $intotalSum - $outtotalSum,
        ]);
    }
}
