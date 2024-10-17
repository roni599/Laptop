<?php

use App\Http\Controllers\ActivityLogController\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bill\BillController;
use App\Http\Controllers\Brand\BrandController;
use App\Http\Controllers\Calculate\CalculateController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\CartItem\CartItemController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Expense\ExpenseCategoryController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Investment\InvestmentController;
use App\Http\Controllers\PaymentType\PaymentTypeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Reserve\ReserveController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Serial\SerialController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

//for role
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles/store', [RoleController::class, 'store']);
Route::put('/roles/update', [RoleController::class, 'update']);
Route::put('/roles/userSelfUpdate', [RoleController::class, 'userSelfUpdate']);
Route::put('/roles/userSelfUpdaePassword', [RoleController::class, 'userSelfUpdatePassword']);
Route::delete('/roles/delete/{id}', [RoleController::class, 'delete']);
Route::get('/activityLog/{id}', [ActivityLogController::class, 'index']);
Route::post('/activityLog/create', [ActivityLogController::class, 'create']);

//for user
Route::get('/alluser', [RoleController::class, 'all']);
Route::put('/user/update', [RoleController::class, 'userUpdate']);
Route::delete('/user/delete/{id}', [RoleController::class, 'deleted']);

//for brand
Route::get('/brands', [BrandController::class, 'index']);
Route::post('/brands/store', [BrandController::class, 'store']);
Route::put('/brands/update', [BrandController::class, 'brandUpdate']);
Route::delete('/brands/delete/{id}', [BrandController::class, 'delete']);

//for category
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories/store', [CategoryController::class, 'store']);
Route::put('/categories/update', [CategoryController::class, 'CategoryUpdate']);
Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);

//for products
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products/store', [ProductController::class, 'store']);
Route::put('/products/update', [ProductController::class, 'ProductsUpdate']);
Route::delete('/products/delete/{id}', [ProductController::class, 'delete']);

//for suppliers
Route::get('/suppliers', [SupplierController::class, 'index']);
Route::post('/suppliers/store', [SupplierController::class, 'store']);
Route::put('/suppliers/update', [SupplierController::class, 'update']);
Route::delete('/suppliers/delete/{id}', [SupplierController::class, 'delete']);

//for stocks
Route::get('/stocks', [StockController::class, 'index']);
Route::post('/stocks/store', [StockController::class, 'store']);
Route::put('/stocks/update', [StockController::class, 'update']);
Route::delete('/stocks/delete/{id}', [StockController::class, 'delete']);
Route::get('/stocks/serial/{stockId}', [SerialController::class, 'getSerialsByStock']);

//for serials
Route::get('/serials', [SerialController::class, 'index']);
Route::post('/serials/store', [SerialController::class, 'store']);
Route::put('/serials/upate', [SerialController::class, 'update']);
Route::delete('/serials/delete/{id}', [SerialController::class, 'delete']);
Route::post('/barcode-search', [SerialController::class, 'searchBarcode']);
Route::post('/submit-sale', [SerialController::class, 'submit_sale']);
Route::delete('/delete-saledata/{id}', [SerialController::class, 'delete_saledata']);

//for paymentType
Route::get('/payment-types', [PaymentTypeController::class, 'index']);
Route::post('/payment-types/store', [PaymentTypeController::class, 'store']);
Route::put('/payment-types/upate', [PaymentTypeController::class, 'update']);
Route::delete('/payment-types/delete/{id}', [PaymentTypeController::class, 'delete']);

//for Investmen
Route::get('/investments', [InvestmentController::class, 'index']);
Route::post('/investments/store', [InvestmentController::class, 'store']);
Route::put('/investments/upate', [InvestmentController::class, 'update']);
Route::delete('/investments/delete/{id}', [InvestmentController::class, 'delete']);

//for Reserve
Route::get('/reserves', [ReserveController::class, 'index']);
Route::post('/reserves/store', [ReserveController::class, 'store']);
Route::put('/reserves/upate', [ReserveController::class, 'update']);
Route::delete('/reserves/delete/{id}', [ReserveController::class, 'delete']);

//for expense category
Route::get('/expensecategory', [ExpenseCategoryController::class, 'index']);
Route::post('/expensecategory/store', [ExpenseCategoryController::class, 'store']);
Route::put('/expensecategory/upate', [ExpenseCategoryController::class, 'update']);
Route::delete('/expensecategory/delete/{id}', [ExpenseCategoryController::class, 'delete']);

//for expense
Route::get('/expense', [ExpenseController::class, 'index']);
Route::post('/expense/store', [ExpenseController::class, 'store']);
Route::put('/expense/upate', [ExpenseController::class, 'update']);
Route::delete('/expense/delete/{id}', [ExpenseController::class, 'delete']);
Route::get('/expense/find/{id}', [ExpenseController::class, 'expensefind']);


Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers/store', [CustomerController::class, 'store']);
Route::put('/customers/update', [CustomerController::class, 'CategoryUpdate']);
Route::delete('/customers/delete/{id}', [CustomerController::class, 'delete']);

Route::get('/bills', [BillController::class, 'index']);
Route::post('/bills/store', [BillController::class, 'store']);
Route::put('/bills/update', [BillController::class, 'CategoryUpdate']);
Route::delete('/bills/delete/{id}', [BillController::class, 'delete']);
Route::get('/bills/generate/{id}', [BillController::class, 'billGenerate']);
Route::get('/bills/table', [BillController::class, 'billtable']);
Route::delete('/bills/table/edit_bill_reserve_delete/{id}', [BillController::class, 'bill_edit_reserve_delete']);
Route::post('/bills/update_bill',[BillController::class, 'billUpdate']);


Route::get('/carts', [CartController::class, 'index']);
Route::get('/cartsitmes', [CartItemController::class, 'index']);


Route::get('/product/calculate',[CalculateController::class, 'product']);
// Route::post('/users/store',[UserController::class, 'store']);
// Route::get('/employees', [EmployeeController::class, 'index']);
// Route::post('/employees/store', [EmployeeController::class, 'store']);
// Route::delete('/employees/delete/{id}', [EmployeeController::class, 'delete']);
// Route::put('/employees/update', [EmployeeController::class, 'update']);

// Route::get('/suppliers', [SupplierController::class, 'index']);
// Route::post('/suppliers/store', [SupplierController::class, 'store']);
// Route::delete('/suppliers/delete/{id}', [SupplierController::class, 'delete']);
// Route::put('/suppliers/update', [SupplierController::class, 'update']);

// Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/categories/store', [CategoryController::class, 'store']);
// Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);
// Route::put('/categories/update', [CategoryController::class, 'update']);

// Route::get('/products', [ProductController::class, 'index']);
// Route::post('/products/store', [ProductController::class, 'store']);
// Route::delete('/products/delete/{id}', [ProductController::class, 'delete']);
// Route::put('/products/update', [ProductController::class, 'update']);
// Route::put('/products/stocks/update', [ProductController::class, 'stocks_update']);

// Route::get('/expenses', [ExpenseController::class, 'index']);
// Route::post('/expenses/store', [ExpenseController::class, 'store']);
// Route::delete('/expenses/delete/{id}', [ExpenseController::class, 'delete']);
// Route::put('/expenses/update', [ExpenseController::class, 'update']);

// Route::get('/customers', [CustomerController::class, 'index']);
// Route::post('/customers/store', [CustomerController::class, 'store']);
// Route::delete('/customers/delete/{id}', [CustomerController::class, 'delete']);
// Route::put('/customers/update', [CustomerController::class, 'update']);

// Route::get('/subproducts/{id}', [CustomerController::class, 'subproduct']);

// Route::get('/addProduct/{id}', [PosController::class, 'addProduct']);
// Route::get('/allPos',[PosController::class, 'allPos']);
// Route::get('/posremove/{id}', [PosController::class, 'posremove']);
// Route::get('/posincrement/{id}', [PosController::class, 'posincrement']);
// Route::get('/posdecrement/{id}', [PosController::class, 'posdecrement']);

// Route::get('/allvat', [ExtraController::class, 'index']);
// Route::post('/order', [ExtraController::class, 'orderDoneCustomer']);
