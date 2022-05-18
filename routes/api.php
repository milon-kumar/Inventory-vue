<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\MonthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth',
], function (){
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('logout',   [AuthController::class, 'logout']);
    Route::post('refresh',  [AuthController::class, 'refresh']);
    Route::post('me',       [AuthController::class, 'me']);
    Route::post('payload',  [AuthController::class, 'payload']);
    Route::post('register', [AuthController::class, 'register']);

});

Route::apiResource('employee',  EmployeeController::class);

Route::apiResource('supplier',  SupplierController::class);

Route::apiResource('category',  CategoryController::class);

Route::apiResource('brand',     BrandController::class);

Route::apiResource('product',   ProductController::class);

Route::apiResource('expense',   ExpenseController::class);

Route::apiResource('salary',    SalaryController::class);

Route::apiResource('customer',  CustomerController::class);

Route::apiResource('pos',       PosController::class);

Route::apiResource('order',     OrderController::class);
Route::get('/order-details/{id}',               [OrderController::class, 'orderDetails']);

Route::delete('/pos/delete-cart/{id}',          [PosController::class, 'deleteItem']);

Route::get('/pos/increment-cart-product/{id}',  [PosController::class, 'incrementProductQty']);
Route::get('/pos/decrement-cart-product/{id}',  [PosController::class, 'decrementProductQty']);

Route::get('/month-salaries/{id}',              [SalaryController::class, 'monthSalary']);
Route::get('/all-month',                        [MonthController::class, 'index']);
Route::get('/employee-salary/{id}',             [MonthController::class, 'employeeSalary']);
Route::get('/product-by-category-id/{id}',      [ProductController::class, 'productByCategory']);

Route::post('/category/update', [CategoryController::class, 'updateCategory']);


Route::post('/upload',function(Request $request){

    $uploadedFiles=$request->pics;

    foreach ($uploadedFiles as $file){
        $file->store('dummy');

    }
    return response(['status'=>'success'],200);

});

Route::post('/upload-single',function(Request $request){

    return $request;

    $files = $request->image;
    $files->store('single');
    return response(['status'=>'success'],200);
});



Route::post('save/emp', [EmployeeController::class, 'saveEmp']);
