<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Cashier\CashierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/managment',function(){
    return  view('managment.index');
});

// Managment routes
Route::resource('management/category', 'App\Http\Controllers\Management\CategoryController');
Route::resource('management/menu', 'App\Http\Controllers\Management\MenuController');
Route::resource('management/table', 'App\Http\Controllers\Management\TableController');

// Cashier routes
Route::delete('/cashier/deleteOrderDetail',[CashierController::class,'deleteOrderDetail']);
Route::get('/cashier/showReceipt/{sale_id}',[CashierController::class,'showReceipt']);
Route::post('/cashier/savePayment',[CashierController::class,'savePayment']);
Route::post('/cashier/orderFood',[CashierController::class,'orderFood']);
Route::post('/cashier/confirmOrder',[CashierController::class,'confirmOrder']);
Route::get('/cashier',[CashierController::class,'index']);
Route::get('/cashier/getMenuByCategory/{category_id}',[CashierController::class,'getMenuByCategory']);
Route::get('cashier/getSailDetailsByTable/{table_id}',[CashierController::class,'getSailDetailsByTable']);
Route::get('/cashier/getTable',[CashierController::class,'getTables']);


// Reports routes 
Route::get('/report',[ReportController::class,'index']);
Route::get('/report/show',[ReportController::class,'show']);






