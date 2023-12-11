<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\Reports\TransactionController as TransactionReportsController;


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


Route::post('login', [LoginController::class, 'apiLogin']);
Route::group(['middleware' => ['verified','auth:sanctum','format']],function (){

    Route::group(['middleware' => ['role:admin']],function (){
        Route::apiResource('transactions',TransactionController::class)->only(['store','index']);
        Route::apiResource('transactions.payments',PaymentController::class)->only(['store']);
        Route::get('/transactions/paymnets',[PaymentController::class , 'indexAll'])->name('transactions.payments.indexAll');
        Route::group(['prefix' => 'reports'], function () {
            Route::get('transactions/monthly', [TransactionReportsController::class, 'monthly'])->name('reports.transactions.monthly');
        });
    });
    Route::apiResource('transactions.payments',PaymentController::class)->only(['index']);
    Route::get('/customer/transactions',[TransactionController::class ,'indexByPayer'])->name('customers.transactions.index');
}); 
 
