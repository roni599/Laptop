<?php

namespace App\Http\Controllers\Calculate;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Investment;
use App\Models\Product;
use App\Models\Reserve;
use App\Models\Stock;
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


        $currentMonthCost = Expense::whereMonth('expenses.date', Carbon::now()->month)
            ->whereYear('expenses.created_at', Carbon::now()->year)
            ->join('expensecategories', 'expenses.expense_category_id', '=', 'expensecategories.id')
            ->where('expensecategories.cost_type', 1)
            ->sum('expenses.amount');
        $thisMonthProfit = Bill::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->with('cart.cartItems')
            ->get()
            ->sum(function ($bill) {
                return $bill->cart->cartItems->sum('total_profit');
            });
        $thisMonthCostProfit = $thisMonthProfit - $currentMonthCost;

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
        $allMonths2 = [
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
        $monthlyData = Bill::selectRaw('MONTHNAME(created_at) as month_name, COUNT(*) as bill_count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month_name')
            ->orderByRaw('FIELD(month_name, "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")')
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
        $monthlyRunningCost = Expense::selectRaw('MONTH(expenses.date) as month, SUM(expenses.amount) as total_amount')
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

        //for in like bank,cash,others
        $totals = Reserve::selectRaw('payment_type_id, SUM(amount) as total_amount')
            ->groupBy('payment_type_id')
            ->get();
        $totalBank = $totals->where('payment_type_id', 1)->first()->total_amount ?? 0;
        $totalCash = $totals->where('payment_type_id', 2)->first()->total_amount ?? 0;
        $totalOthers = $totals->where('payment_type_id', 3)->first()->total_amount ?? 0;

        //for out like bank,cash,others
        $totals = Reserve::selectRaw('payment_type_id, SUM(amount) as total_amount')
            ->where('transaction_type', 'out') // Filter for "out" transactions
            ->groupBy('payment_type_id')
            ->get();
        $totalOUtBank = $totals->where('payment_type_id', 1)->first()->total_amount ?? 0;
        $totalOUtCash = $totals->where('payment_type_id', 2)->first()->total_amount ?? 0;
        $totalOUtOthers = $totals->where('payment_type_id', 3)->first()->total_amount ?? 0;

        //for net taka
        $netTotalBank = $totalBank - $totalOUtBank;
        $netTotalCash = $totalCash - $totalOUtCash;
        $netTotalOthers = $totalOthers - $totalOUtOthers;



        //for runnig_cost,fixed_cost
        $totals = Expense::selectRaw('expensecategories.cost_type, SUM(expenses.amount) as total_amount')
            ->join('expensecategories', 'expenses.expense_category_id', '=', 'expensecategories.id')
            ->groupBy('expensecategories.cost_type')
            ->get();
        $runningCost = $totals->where('cost_type', 1)->first()->total_amount ?? 0;
        $fixedCost = $totals->where('cost_type', 2)->first()->total_amount ?? 0;



        //monthly profit && without profit
        $monthlyData = Bill::selectRaw('MONTHNAME(created_at) as month_name, SUM(total_price) as total_price_sum')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month_name')
            ->orderByRaw('FIELD(month_name, "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")')
            ->get()
            ->pluck('total_price_sum', 'month_name')
            ->toArray();
        foreach ($monthlyData as $month => $total) {
            if (array_key_exists($month, $allMonths)) {
                $allMonths[$month] = $total;
            }
        }


        $monthlyData = CartItem::selectRaw('MONTHNAME(created_at) as month_name, SUM(unit_price) as total_unit_price_sum')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month_name')
            ->orderByRaw('FIELD(month_name, "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")')
            ->get()
            ->pluck('total_unit_price_sum', 'month_name')
            ->toArray();
        foreach ($monthlyData as $month => $total) {
            if (array_key_exists($month, $allMonths2)) {
                $allMonths2[$month] = $total;
            }
        }
        //my total product price that stay have my shop
        $stocks = Stock::with(['product.brand', 'product.category']) // Eager load brand and category
            ->whereHas('product', function ($query) {
                $query->where('quantity', '>', 0);
            })
            ->get();

        $totalPrice = $stocks->sum(function ($stock) {
            return $stock->buying_price * $stock->product->quantity;
        });

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

            //for in like bank,cash,others
            'total_bank' => $totalBank,
            'total_cash' => $totalCash,
            'total_others' => $totalOthers,

            //for out like bank,cash,others
            'total_Out_bank' => $totalOUtBank,
            'total_Out_cash' => $totalOUtCash,
            'total_Out_others' => $totalOUtOthers,


            //net for bank,cash,others
            'net_Bank' => $netTotalBank,
            'net_Cash' => $netTotalCash,
            'net_Others' => $netTotalOthers,

            //for runnig_cost,fixed_cost
            'running_cost' => $runningCost,
            'fixed_cost' => $fixedCost,

            //monthly profit && without profit
            'allMonths' => $allMonths,
            'allMonths2' => $allMonths2,


            'totalPrice' => $totalPrice,


        ]);
    }
}
